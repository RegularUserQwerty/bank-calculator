<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">

    <!-- заголовок сайта -->
    <title>Bank Calculator</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<!-- верхняя панель -->
<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">

        <a class="navbar-brand" href="/calculator">
            🏦 Bank Calculator
        </a>

        <div>
            <a href="/calculator" class="btn btn-outline-light me-2">
                Калькулятор
            </a>

            <a href="/history" class="btn btn-outline-light me-2">
                История
            </a>

            <a href="/admin" class="btn btn-warning me-2">
                Админка
            </a>

            <a href="/admin/logout" class="btn btn-danger">
                Выход
            </a>
        </div>
    </div>
</nav>

<!-- контент страницы -->
<div class="container mt-5">
		@if(session('success'))
    	<div class="alert alert-success">
        {{ session('success') }}
    	</div>
		@endif
   @yield('content')

</div>

</body>
</html>