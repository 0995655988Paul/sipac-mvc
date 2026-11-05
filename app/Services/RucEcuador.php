<?php

namespace App\Services;

/**
 * Regla de negocio sensible: valida un RUC ecuatoriano en el servidor.
 * No se confía en atributos HTML ni en JavaScript; la regla se ejecuta
 * antes de persistir el proveedor y además existe un índice UNIQUE.
 */
class RucEcuador
{
    public static function normalizar(string $valor): string
    {
        return preg_replace('/\D+/', '', $valor) ?? '';
    }

    public static function esValido(string $valor): bool
    {
        $ruc = self::normalizar($valor);
        if (strlen($ruc) !== 13 || substr($ruc, -3) !== '001') {
            return false;
        }

        $provincia = (int) substr($ruc, 0, 2);
        if ($provincia < 1 || $provincia > 24) {
            return false;
        }

        $tercerDigito = (int) $ruc[2];
        if ($tercerDigito === 9) {
            return self::verificarModuloOnce(substr($ruc, 0, 9), (int) $ruc[9], [4, 3, 2, 7, 6, 5, 4, 3, 2]);
        }
        if ($tercerDigito === 6) {
            return self::verificarModuloOnce(substr($ruc, 0, 9), (int) $ruc[9], [3, 2, 7, 6, 5, 4, 3, 2, 1]);
        }

        $cedula = substr($ruc, 0, 10);
        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;
        foreach ($coeficientes as $indice => $coeficiente) {
            $producto = ((int) $cedula[$indice]) * $coeficiente;
            $suma += $producto > 9 ? $producto - 9 : $producto;
        }

        $verificador = (10 - ($suma % 10)) % 10;

        return $verificador === (int) $cedula[9];
    }

    private static function verificarModuloOnce(string $base, int $digito, array $coeficientes): bool
    {
        $suma = 0;
        foreach ($coeficientes as $indice => $coeficiente) {
            $suma += ((int) $base[$indice]) * $coeficiente;
        }
        $verificador = 11 - ($suma % 11);
        if ($verificador === 10 || $verificador === 11) {
            $verificador = 0;
        }

        return $verificador === $digito;
    }
}
