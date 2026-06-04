@extends('layout')

@section('content')

<div class="card shadow border-0">
    <div class="card-body">

        <h2 class="mb-4">Результат расчёта</h2>

        <p><b>Тип:</b> {{ $type }}</p>

        @if($type === 'Пенсионные накопления')

            <p><b>Итоговый капитал:</b> {{ $totalCapital }} руб.</p>
            <p><b>Пенсия в месяц:</b> {{ $monthlyPayment }} руб.</p>

        @else

            <p><b>Сумма кредита:</b> {{ number_format($loan, 0, ',', ' ') }} руб.</p>

            <p><b>Ставка:</b> {{ $rate }}%</p>

            <hr>

            <h3>{{ $resultText ?? 'Ежемесячный платёж' }}:</h3>

            <h1 class="text-success">
                {{ number_format($payment, 0, ',', ' ') }} руб.
            </h1>

            <p><b>Срок кредита:</b> {{ $years }} лет</p>

            <p>
                <b>Общая сумма выплат:</b>
                {{ number_format($totalPayment, 0, ',', ' ') }} руб.
            </p>

            <p>
                <b>Переплата по кредиту:</b>
                {{ number_format($overpayment, 0, ',', ' ') }} руб.
            </p>

            {{-- Необходимый доход из ТЗ --}}
            <p>
                <b>Необходимый доход:</b>
                {{ number_format(round($payment * 2.5), 0, ',', ' ') }} руб.
            </p>

        @endif

        <hr>

        <a href="/calculator" class="btn btn-primary">
            Новый расчёт
        </a>

    </div>
</div>

@endsection