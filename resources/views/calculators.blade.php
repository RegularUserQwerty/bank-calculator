@extends('layout')

@section('content')

<h1 class="mb-4">Управление калькуляторами</h1>

<a href="/admin" class="btn btn-secondary mb-3">
    Назад
</a>

<a href="/admin/calculators/create"
   class="btn btn-success mb-3">
    Добавить калькулятор
</a>

<table class="table table-bordered">

    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Код</th>
        <th>Ставка</th>
        <th>Текст результата</th>
				<th>Действия</th>
    </tr>

    @foreach($calculators as $calculator)

    <tr>
        <td>{{ $calculator->id }}</td>
        <td>{{ $calculator->name }}</td>
        <td>{{ $calculator->code }}</td>
        <td>{{ $calculator->rate }}%</td>
        <td>{{ $calculator->result_text }}</td>
				<td>
					<a href="/admin/calculators/edit/{{ 	$calculator->id }}"
       			class="btn btn-warning btn-sm">
        		Изменить
    			</a>

					<a href="/admin/calculators/delete/{{ $calculator->id }}"
						class="btn btn-danger btn-sm"
						onclick="return confirm('Удалить калькулятор?')">
						Удалить
					</a>

				</td>
    </tr>

    @endforeach

</table>

@endsection