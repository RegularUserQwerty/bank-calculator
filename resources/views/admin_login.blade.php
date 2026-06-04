@extends('layout')

@section('content')

<div class="card shadow" style="max-width: 400px; margin: 80px auto;">
    <div class="card-body">

        <h2 class="mb-4">Вход в админку</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/admin/login" autocomplete="off">
            @csrf

            <div class="mb-3">
                <label>Логин</label>
                <input type="text" name="login" class="form-control" autocomplete="off">
            </div>

            <div class="mb-3">
                <label>Пароль</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password">
            </div>

            <button class="btn btn-primary w-100">
                Войти
            </button>

        </form>

    </div>
</div>

@endsection