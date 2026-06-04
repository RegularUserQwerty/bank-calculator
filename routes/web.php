<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Models\Calculation;
use App\Mail\CalculationResultMail;
use Illuminate\Http\Request;
use App\Models\Calculator;

/*
 ПЕРЕХОДЫ САЙТА
*/

// главная
Route::get('/', function () {
    return view('welcome');
});

// калькулятор
Route::get('/calculator', function () {

    $calculators = Calculator::all();

    return view('calculator', compact('calculators'));
});

// история (только админ)
Route::get('/history', function () {

    if (!session('admin')) {
        return redirect('/admin/login');
    }

    $calculations = Calculation::orderBy('id', 'desc')->get();

    return view('history', compact('calculations'));
});

// удаление расчёта (только админ)
Route::get('/delete/{id}', function ($id) {

    if (!session('admin')) {
        return redirect('/admin/login');
    }

    Calculation::findOrFail($id)->delete();

    return redirect()->back()->with('success', 'Удалено');
});

/*
РАСЧЁТ КАЛЬКУЛЯТОРА
*/

Route::post('/calculator', function () {

    $type = request('loan_type');

    /*
     ПЕНСИОННЫЙ КАЛЬКУЛЯТОР (ОТДЕЛЬНАЯ ЛОГИКА)
    */

    if ($type === 'pension') {

				$calculator = Calculator::where('code', 'pension')->first();
        $currentAge = request('current_age');
        $retirementAge = request('retirement_age');
        $start = request('pension_start');
        $monthly = request('monthly_contribution');

        // параметры модели
        $income = 0.08;
        $inflation = 0.04;

        $r = $income - $inflation;
        $n = $retirementAge - $currentAge;

        $S = $start;

        for ($i = 0; $i < $n; $i++) {
            $S = ($S * (1 + $r)) + (($monthly * 12) * (1 + $r));
        }

        $monthlyPension = $S / 270;

        return view('result', [
					'type' => $calculator->name ?? 'Пенсионные накопления',
					'monthlyPayment' => round($monthlyPension),
					'totalCapital' => round($S),
					'resultText' => $calculator->result_text ?? 'Результат',
				]);
    }

    /*
     КРЕДИТНАЯ ЧАСТЬ
    */

$calculator = Calculator::where('code', $type)->first();

if (!$calculator) {
    return back()->with('error', 'Калькулятор не найден');
}

$rate = $calculator->rate;

    $price = request('price');
    $down = request('down_payment') ?? 0;
    $years = request('years');

    // сумма кредита
    $loan = ($type === 'mortgage')
        ? ($price - $down)
        : $price;

    // расчёт кредита
    $monthlyRate = $rate / 12 / 100;
    $totalRate = pow(1 + $monthlyRate, $years * 12);

    $monthlyPayment = $loan * $monthlyRate * $totalRate / ($totalRate - 1);

    $totalPayment = round($monthlyPayment * $years * 12);
    $overpayment = round($totalPayment - $loan);

    // сохраняем
    Calculation::create([
        'price' => $price,
        'down_payment' => $down,
        'years' => $years,
        'monthly_payment' => round($monthlyPayment),
        'email' => request('email'),
    ]);

    // email
    Mail::to(request('email'))
        ->send(new CalculationResultMail(
            round($monthlyPayment),
            $years,
            $type,
            $rate
        ));

    // русский текст
$typeLabel = $calculator->name;

    // результат
    return view('result', [
        'type' => $typeLabel,
        'payment' => round($monthlyPayment),
        'years' => $years,
        'rate' => $rate,
        'loan' => $loan,
        'totalPayment' => $totalPayment,
        'overpayment' => $overpayment,
				'resultText' => $calculator->result_text,
    ]);
});

/*
АДМИНКА
*/

// вход
Route::get('/admin/login', function () {
    return view('admin_login');
});

Route::post('/admin/login', function () {

    $login = request('login');
    $password = request('password');

    if ($login === 'admin' && $password === '1234') {
        session(['admin' => true]);
        return redirect('/admin');
    }

    return back()->with('error', 'Неверный логин или пароль');
});

// админ панель
Route::get('/admin', function () {

    if (!session('admin')) {
        return redirect('/admin/login');
    }

    $calculations = Calculation::all();

    return view('admin', compact('calculations'));
});

// выход
Route::get('/admin/logout', function () {
    session()->forget('admin');
    return redirect('/admin/login');
});

Route::get('/admin/calculators', function () {

    if (!session('admin')) {
        return redirect('/admin/login');
    }

    $calculators = Calculator::all();

    return view('calculators', compact('calculators'));
});

Route::get('/admin/calculators/delete/{id}', function ($id) {

    if (!session('admin')) {
        return redirect('/admin/login');
    }

    Calculator::findOrFail($id)->delete();

    return redirect('/admin/calculators');
});

Route::get('/admin/calculators/edit/{id}', function ($id) {

    if (!session('admin')) {
        return redirect('/admin/login');
    }

    $calculator = Calculator::findOrFail($id);

    return view('calculator_edit', compact('calculator'));
});

Route::post('/admin/calculators/edit/{id}', function ($id) {

    $calculator = Calculator::findOrFail($id);

    $calculator->update([
        'name' => request('name'),
        'rate' => request('rate'),
        'result_text' => request('result_text')
    ]);

    return redirect('/admin/calculators');
});

Route::get('/admin/calculators/create', function () {

    return view('calculator_create');
});

Route::post('/admin/calculators/create', function () {

    Calculator::create([
        'name' => request('name'),
        'code' => request('code'),
        'rate' => request('rate'),
        'result_text' => request('result_text')
    ]);

    return redirect('/admin/calculators');
});