<?php

namespace App\Services;

class PlanificacionService
{
    public static function necesidad(int $consumo, int $stockSeguridad, int $stock, int $pendiente): int
    {
        return max(0, $consumo + $stockSeguridad - $stock - $pendiente);
    }

    public static function costo(int $cantidad, float $precio, float $adicional): float
    {
        return round($cantidad * ($precio + $adicional), 2);
    }

    public static function motivo(int $necesidad, int $cantidad, ?array $cotizacion): string
    {
        if ($necesidad === 0) {
            return 'No se genera compra: el saldo cubre el nivel requerido.';
        }
        if ($cotizacion === null) {
            return 'Necesidad detectada, pero no existe una cotización vigente seleccionada.';
        }
        if ($cantidad < $necesidad) {
            return 'Cobertura parcial por disponibilidad limitada de la oferta.';
        }

        return 'Cobertura completa con la oferta vigente seleccionada.';
    }
}
