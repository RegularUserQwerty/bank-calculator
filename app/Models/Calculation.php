<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model //это сама таблица
{
    protected $fillable = [ //филлебл - список полей которые ларавель разрешает записывать 
    'price',
    'down_payment',
    'years',
    'monthly_payment',
		'email' // email пользователя
];
}

