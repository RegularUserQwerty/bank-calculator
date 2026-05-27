@extends('layout')

@section('content')

<div class="card shadow border-0">
    <div class="card-body">

        <h2 class="mb-4">Результат расчёта</h2>

        <p><b>Тип кредита:</b> {{ $type }}</p>
        <p><b>Сумма кредита:</b> {{ $loan }}</p>
        <p><b>Ставка:</b> {{ $rate }}%</p>

        <hr>

        <h3>Ежемесячный платёж:</h3>
        <h1 class="text-success">{{ $payment }} руб</h1>

        <p>Срок: {{ $years }} лет</p>

        <hr>

        <a href="/calculator" class="btn btn-primary">
            Новый расчёт
        </a>

    </div>
</div>

@endsection