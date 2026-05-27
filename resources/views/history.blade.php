@extends('layout')

@section('content')

<h1>История расчетов</h1>

<a href="/calculator">← К калькулятору</a>

<hr>

@foreach($calculations as $calc)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <p>Стоимость: {{ $calc->price }}</p>
        <p>Первоначальный взнос: {{ $calc->down_payment }}</p>
        <p>Срок: {{ $calc->years }} лет</p>
        <p><b>Платёж: {{ $calc->monthly_payment }} руб</b></p>
        <small>{{ $calc->created_at }}</small>

				<a href="/delete/{{ $calc->id }}"
   			onclick="return confirm('Удалить расчёт?')"
   			style="color:red;">
   			Удалить
</a>
    </div>
@endforeach

@endsection