<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    protected $fillable = [
        'name',
        'code',
        'rate',
        'result_text'
    ];

}
