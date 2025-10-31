<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaDePagamento extends Model
{
    use HasFactory;

    // Definindo explicitamente o nome da tabela
    protected $table = 'formas_de_pagamento'; // Nome correto da tabela no banco
    protected $fillable = ['nome']; // Campos que podem ser preenchidos
    
    // Caso não queira timestamps, pode desabilitar assim:
    public $timestamps = false;
}
