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

    						@foreach($calculators as $calculator)

        				<option value="{{ $calculator->code }}">
            		{{ $calculator->name }}
        				</option>

    						@endforeach

							</select>

						<div id="pension-fields" style="display:none;">
								<div class="mb-3">
    							<label>Текущий возраст</label>
    							<input type="number" name="current_age" class="form-control">
								</div>

								<div class="mb-3">
									<label>Возраст выхода на пенсию</label>
									<input type="number" name="retirement_age" class="form-control">
								</div>

								<div class="mb-3">
									<label>Текущие накопления</label>
									<input type="number" name="pension_start" class="form-control">
								</div>

								<div class="mb-3">
									<label>Ежемесячный взнос</label>
									<input type="number" name="monthly_contribution" class="form-control">
								</div>
							</div>

						</div>
					<div id="credit-fields">	
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
const creditFields = document.querySelector('#credit-fields');
const pensionFields = document.querySelector('#pension-fields');
const downBlock = document.querySelector('#down-block');

function updateUI() {
    const value = loanType.value;

    //  текст
    if (value === 'mortgage') {
        label.innerText = 'Стоимость недвижимости';
    } else if (value === 'auto') {
        label.innerText = 'Стоимость автомобиля';
    } else {
        label.innerText = 'Сумма кредита';
    }

    //  переключение режимов
    if (value === 'pension') {
        creditFields.style.display = 'none';
        pensionFields.style.display = 'block';
    } else {
        creditFields.style.display = 'block';
        pensionFields.style.display = 'none';
    }

    //  первоначальный взнос только для ипотеки
    if (value === 'mortgage') {
        downBlock.style.display = 'block';
    } else {
        downBlock.style.display = 'none';
    }
		if (value === 'pension') {
    		creditFields.style.display = 'none';
    		pensionFields.style.display = 'block';

    		creditFields.querySelectorAll('input').forEach(i => i.disabled = true);
    		pensionFields.querySelectorAll('input').forEach(i => i.disabled = false);

		} else {
    		creditFields.style.display = 'block';
    		pensionFields.style.display = 'none';

    		creditFields.querySelectorAll('input').forEach(i => i.disabled = false);
    		pensionFields.querySelectorAll('input').forEach(i => i.disabled = true);
}
}

loanType.addEventListener('change', updateUI);
updateUI();
</script>

@endsection