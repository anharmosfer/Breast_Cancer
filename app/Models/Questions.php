<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'marital_status',
        'birthdate',
        'rate',
    ];

    protected $casts = [
        'gender' => 'json',
        'marital_status' => 'json',
        'birthdate' => 'json',
    ];

}






