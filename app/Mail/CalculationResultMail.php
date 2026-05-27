<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class CalculationResultMail extends Mailable
{
    public $payment;
    public $years;
    public $type;
    public $rate;

    // передаём данные в письмо
    public function __construct($payment, $years, $type, $rate)
    {
        $this->payment = $payment; // ежемесячный платёж
        $this->years = $years;     // срок
        $this->type = $type;       // тип кредита
        $this->rate = $rate;       // процент
    }

    public function build()
    {
        return $this
            ->subject('Результат расчёта кредита')
            ->view('emails.calculation');
    }
}