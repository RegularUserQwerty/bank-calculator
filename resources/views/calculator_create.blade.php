@extends('layout')

@section('content')

<h1>Добавить калькулятор</h1>

<form method="POST">

    @csrf

    <div class="mb-3">
        <label>Название</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="mb-3">
        <label>Код</label>
        <input type="text" name="code" class="form-control">
    </div>

    <div class="mb-3">
        <label>Ставка</label>
        <input type="number" step="0.01" name="rate" class="form-control">
    </div>

    <div class="mb-3">
        <label>Текст результата</label>
        <input type="text" name="result_text" class="form-control">
    </div>

    <button class="btn btn-success">
        Добавить
    </button>

</form>

@endsection