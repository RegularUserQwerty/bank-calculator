@extends('layout')

@section('content')

<div class="card shadow border-0">

    <div class="card-body">

        <!-- заголовок -->
        <h1 class="mb-4">
            Кредитный калькулятор
        </h1>

        <!-- форма расчета -->
        <form method="POST" action="/calculator">

            @csrf
						<!-- тип кредита -->
						<div class="mb-3">
    					<label class="form-label">Тип кредита</label>

    					<select name="loan_type" class="form-control" required>
        				<option value="mortgage">Ипотека</option>
        				<option value="auto">Автокредит</option>
        				<option value="consumer">Потребительский</option>
    					</select>
						</div>
            <!-- стоимость -->
            <div class="mb-3">
                <label class="form-label" id="price-label">
    							Стоимость недвижимости
								</label>

                <input type="number"
                       name="price"
                       class="form-control"
                       required>
            </div>

            <!-- первоначальный взнос -->
            <div class="mb-3" id="down-block">
							<label class="form-label">
									Первоначальный взнос
							</label>

							<input type="number"
										name="down_payment"
										class="form-control">
						</div>

            <!-- срок -->
            <div class="mb-3">
                <label class="form-label">
                    Срок кредита (лет)
                </label>

                <input type="number"
                       name="years"
                       class="form-control"
                       required>
            </div>

            <!-- email -->
            <div class="mb-3">
                <label class="form-label">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>

            <!-- кнопка -->
            <button type="submit"
                    class="btn btn-primary">
                Рассчитать
            </button>

        </form>

    </div>
</div>

<!-- скрипт для динамического изменения текста -->
<script>
    const loanType = document.querySelector('select[name="loan_type"]');
    const label = document.querySelector('#price-label');

    function updateLabel() {
        const value = loanType.value;

        if (value === 'mortgage') {
            label.innerText = 'Стоимость недвижимости';
        } 
        else if (value === 'auto') {
            label.innerText = 'Стоимость автомобиля';
        } 
        else {
            label.innerText = 'Сумма кредита';
        }
    }

    // при изменении select
    loanType.addEventListener('change', updateLabel);

    // при загрузке страницы
    updateLabel();

		// блок первоначального взноса
		const downBlock = document.querySelector('#down-block');

		function updateDownPayment() {
    	const value = loanType.value;

    	if (value === 'mortgage') {
        downBlock.style.display = 'block';
    	} else {
        downBlock.style.display = 'none';
    	}
}

// при изменении
loanType.addEventListener('change', updateDownPayment);

// при загрузке
updateDownPayment();
</script>

@endsection