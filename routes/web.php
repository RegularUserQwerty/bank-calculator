<?php

use Illuminate\Support\Facades\Mail;

use App\Mail\CalculationResultMail;

use Illuminate\Support\Facades\Route;

use App\Models\Calculation;

Route::get('/history', function () {
    $calculations = Calculation::orderBy('id', 'desc')->get();

    return view('history', compact('calculatioпогналиns'));
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/calculator', function () {
    return view('calculator');
});
use Illuminate\Http\Request;

Route::get('/calculator', function () {
    return view('calculator');
});

Route::get('/delete/{id}', function ($id) {
    App\Models\Calculation::findOrFail($id)->delete();
   // возвращаемся назад (откуда пришли)
    return redirect()->back()->with('success', 'Удалено');
});

Route::post('/calculator', function () {

    // тип кредита из формы
    $type = request('loan_type');

    // ставка по типу кредита
    if ($type == 'mortgage') {
        $rate = 9.6; // ипотека
    } elseif ($type == 'auto') {
        $rate = 3.5; // автокредит
    } else {
        $rate = 14.5; // потребительский
    }

    // входные данные
    $price = request('price');
    $down = request('down_payment');
    $years = request('years');

    // сумма кредита
    if ($type == 'mortgage') {
    // ипотека — учитываем взнос
    $loan = $price - $down;
} else {
    // авто и потребительский - без взноса
    $loan = $price;
}

    // месячная ставка
    $monthlyRate = $rate / 12 / 100;

    // формула сложного процента
    $totalRate = pow(1 + $monthlyRate, $years * 12);

    $monthlyPayment = $loan * $monthlyRate * $totalRate / ($totalRate - 1);

    // сохраняем в базу
    App\Models\Calculation::create([
        'price' => $price,
        'down_payment' => $down,
        'years' => $years,
        'monthly_payment' => round($monthlyPayment),
        'email' => request('email')
    ]);

		// отправка email пользователю
		Mail::to(request('email'))
    	->send(new CalculationResultMail(
        round($monthlyPayment), // платёж
        $years,                 // срок
        $type,                  // тип кредита
        $rate                   // ставка
    ));

		// перевод типа кредита на русский
		$typeLabel = match ($type) {
    'mortgage' => 'Ипотека',
    'auto' => 'Автокредит',
    'consumer' => 'Потребительский кредит',
};

    // вывод результата
    return view('result', [
    'payment' => round($monthlyPayment),
    'years' => $years,
    'type' => $typeLabel,
    'rate' => $rate,
    'loan' => $loan
]);
});

Route::get('/admin', function () {

    // если не залогинен - кидаем на логин
    if (!session('admin')) {
        return redirect('/admin/login');
    }

    $calculations = App\Models\Calculation::all();

    return view('admin', compact('calculations'));
});

// форма логина
Route::get('/admin/login', function () {
    return view('admin_login');
});

// обработка логина
Route::post('/admin/login', function () {

    $login = request('login');
    $password = request('password');

    //проверка 
    if ($login === 'admin' && $password === '1234') {
        session(['admin' => true]); // сохраняем вход
        return redirect('/admin');
    }

    return back()->with('error', 'Неверный логин или пароль');
});

// выход
Route::get('/admin/logout', function () {
    session()->forget('admin');
    return redirect('/admin/login');
});

Route::get('/delete/{id}', function ($id) {

    if (!session('admin')) {
        return redirect('/admin/login');
    }

    App\Models\Calculation::findOrFail($id)->delete();

    return redirect()->back()->with('success', 'Удалено');
});