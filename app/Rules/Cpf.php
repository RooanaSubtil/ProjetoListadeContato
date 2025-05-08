<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cpf implements Rule
{
    public function passes($attribute, $value)
    {
        // Exemplo básico: 11 dígitos numéricos
        $cpf = preg_replace('/\D/', '', $value);

        // Verifica se o CPF tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se o CPF é composto por números repetidos (exemplo: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação dos dígitos verificadores
        $soma1 = 0;
        $soma2 = 0;
        $fator1 = [10, 9, 8, 7, 6, 5, 4, 3, 2];
        $fator2 = [11, 10, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 9; $i++) {
            $soma1 += $cpf[$i] * $fator1[$i];
            $soma2 += $cpf[$i] * $fator2[$i];
        }

        $digito1 = ($soma1 % 11 < 2) ? 0 : 11 - ($soma1 % 11);
        $digito2 = ($soma2 % 11 < 2) ? 0 : 11 - ($soma2 % 11);

        // Verifica se os dois últimos dígitos são válidos
        return $cpf[9] == $digito1 && $cpf[10] == $digito2;    }

    public function message()
    {
        return 'O CPF informado é inválido.';
    }
}
