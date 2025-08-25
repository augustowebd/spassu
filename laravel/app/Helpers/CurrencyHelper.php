<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Converte moeda pt-BR (1.234,56) para decimal (1234.56)
     */
    public static function brlToDecimal(string $value): float
    {
        if (empty($value)) { return 0.0; }
        $normalized = str_replace(['.', ','], ['', '.'], $value);

        return (float) $normalized;
    }

    /**
     * Converte decimal (1234.56) para moeda pt-BR (1.234,56)
     */
    public static function decimalToBrl(float $value): string
    {
        return number_format($value, 2, ',', '.');
    }
}
