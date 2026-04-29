<?php

namespace App\Http\Requests\Financeiro;

use Illuminate\Foundation\Http\FormRequest;

class ImportarDespesaExcelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'arquivo' => ['required', 'file', 'mimes:xlsx,xls'],
        ];
    }

    public function messages(): array
    {
        return [
            'arquivo.required' => 'Selecione um arquivo para importar.',
            'arquivo.file'     => 'Arquivo inválido.',
            'arquivo.mimes'    => 'Envie um arquivo Excel válido (.xlsx ou .xls).',
        ];
    }
}