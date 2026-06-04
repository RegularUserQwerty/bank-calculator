@extends('layout')

@section('content')

<h1>Редактирование калькулятора</h1>

<form method="POST">

    @csrf

    <div class="mb-3">
        <label>Название</label>
        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ $calculator->name }}">
    </div>

    <div class="mb-3">
        <label>Ставка (%)</label>
        <input
            type="number"
            step="0.01"
            name="rate"
            class="form-control"
            value="{{ $calculator->rate }}">
    </div>

    <div class="mb-3">
        <label>Текст результата</label>
        <input
            type="text"
            name="result_text"
            class="form-control"
            value="{{ $calculator->result_text }}">
    </div>

    <button class="btn btn-primary">
        Сохранить
    </button>

</form>

@endsection