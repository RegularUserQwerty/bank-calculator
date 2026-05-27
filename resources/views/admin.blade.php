@extends('layout')

@section('content')

<h1 class="mb-4">Админ-панель</h1>

<a href="/calculator" class="btn btn-primary">Калькулятор</a>
<a href="/history" class="btn btn-secondary">История</a>

<hr>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Стоимость</th>
        <th>Взнос</th>
        <th>Срок</th>
        <th>Платёж</th>
        <th>Дата</th>
        <th>Действие</th>
    </tr>

    @foreach($calculations as $calc)
    <tr>
        <td>{{ $calc->id }}</td>
        <td>{{ $calc->price }}</td>
        <td>{{ $calc->down_payment }}</td>
        <td>{{ $calc->years }}</td>
        <td>{{ $calc->monthly_payment }}</td>
        <td>{{ $calc->created_at }}</td>
        <td>
            <a href="/delete/{{ $calc->id }}"
   						class="btn btn-danger btn-sm"
   						onclick="return confirm('Удалить?')">
   						удалить
						</a>
        </td>
    </tr>
    @endforeach
</table>

@endsection