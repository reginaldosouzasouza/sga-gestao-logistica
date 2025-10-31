<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormasDePagamento extends Model
{
    use HasFactory;

    protected $table = 'formas_de_pagamento'; // Adicione esta linha

    protected $fillable = [
        'nome',
        'created_at',
        'updated_at',
    ];
}

