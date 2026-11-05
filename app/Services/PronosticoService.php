<?php

namespace App\Services;

class PronosticoService
{
    public const ALPHA = 0.3;

    /** Suavización exponencial simple: el nivel inicia en el primer mes. */
    public static function suavizar(array $consumos, float $alpha = self::ALPHA): int
    {
        $valores = array_values(array_filter(array_map('intval', $consumos), static fn (int $valor): bool => $valor >= 0));
        if ($valores === []) {
            return 0;
        }

        $nivel = (float) $valores[0];
        foreach (array_slice($valores, 1) as $valor) {
            $nivel = ($alpha * $valor) + ((1 - $alpha) * $nivel);
        }

        return (int) ceil($nivel);
    }
}
