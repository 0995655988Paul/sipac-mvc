<?php

namespace App\Services;

use App\Models\MovimientoInventarioModel;

class InventarioService
{
    public function saldo(int $productoId): int
    {
        $movimientos = (new MovimientoInventarioModel())->where('producto_id', $productoId)->findAll();
        $saldo = 0;
        foreach ($movimientos as $movimiento) {
            $cantidad = (int) $movimiento['cantidad'];
            $saldo += $movimiento['tipo'] === 'consumo' ? -$cantidad : $cantidad;
        }

        return max(0, $saldo);
    }

    public function saldos(): array
    {
        $movimientos = (new MovimientoInventarioModel())->findAll();
        $saldos = [];
        foreach ($movimientos as $movimiento) {
            $id = (int) $movimiento['producto_id'];
            $saldos[$id] = ($saldos[$id] ?? 0) + ($movimiento['tipo'] === 'consumo' ? -(int) $movimiento['cantidad'] : (int) $movimiento['cantidad']);
        }
        foreach ($saldos as &$saldo) {
            $saldo = max(0, $saldo);
        }

        return $saldos;
    }
}
