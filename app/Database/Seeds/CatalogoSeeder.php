<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CatalogoSeeder extends Seeder
{
    public function run()
    {
        $db = $this->db;

        if ($db->table('usuarios')->countAllResults() === 0) {
            $db->table('usuarios')->insert([
                'nombre' => 'Administrador SIPAC',
                'correo' => 'admin@sipac.local',
                'clave_hash' => password_hash('Admin123!', PASSWORD_BCRYPT),
                'rol' => 'ADMIN',
                'activo' => 1,
            ]);
        }

        if ($db->table('productos')->countAllResults() === 0) {
            $db->table('productos')->insertBatch([
                ['codigo' => 'ARROZ-001', 'nombre' => 'Arroz institucional', 'unidad' => 'quintal', 'stock_seguridad' => 20, 'prioridad' => 3, 'activo' => 1],
                ['codigo' => 'PAPEL-002', 'nombre' => 'Papel bond A4', 'unidad' => 'resma', 'stock_seguridad' => 10, 'prioridad' => 2, 'activo' => 1],
                ['codigo' => 'LIMPI-003', 'nombre' => 'Kit de limpieza', 'unidad' => 'kit', 'stock_seguridad' => 6, 'prioridad' => 1, 'activo' => 1],
            ]);
        }

        if ($db->table('proveedores')->countAllResults() === 0) {
            $db->table('proveedores')->insertBatch([
                ['razon_social' => 'Distribuidora Andina S.A.', 'identificacion_fiscal' => '1790016919001', 'contacto' => 'María Paredes', 'correo' => 'ventas@andina.test', 'telefono' => '0991234567', 'activo' => 1],
                ['razon_social' => 'Comercial Sierra Norte', 'identificacion_fiscal' => '0990004196001', 'contacto' => 'Luis Cedeño', 'correo' => 'compras@sierra.test', 'telefono' => '0987654321', 'activo' => 1],
            ]);
        }

        if ($db->table('presupuestos')->countAllResults() === 0) {
            $db->table('presupuestos')->insertBatch([
                ['periodo' => date('Y-m'), 'monto_autorizado' => 1500.00],
                ['periodo' => date('Y-m', strtotime('+1 month')), 'monto_autorizado' => 1800.00],
            ]);
        }

        if ($db->table('cotizaciones')->countAllResults() === 0) {
            $proveedor = $db->table('proveedores')->select('id')->orderBy('id', 'ASC')->get()->getRowArray();
            $productos = $db->table('productos')->select('id,codigo')->orderBy('id', 'ASC')->get()->getResultArray();
            $db->table('cotizaciones')->insert([
                'proveedor_id' => $proveedor['id'],
                'fecha_emision' => date('Y-m-d'),
                'valida_hasta' => date('Y-m-d', strtotime('+45 days')),
                'estado' => 'VIGENTE',
            ]);
            $cotizacionId = $db->insertID();
            foreach ($productos as $index => $producto) {
                $db->table('detalle_cotizaciones')->insert([
                    'cotizacion_id' => $cotizacionId,
                    'producto_id' => $producto['id'],
                    'cantidad_disponible' => $index === 0 ? 100 : 60,
                    'precio_unitario' => $index === 0 ? 10.00 : ($index === 1 ? 4.50 : 12.00),
                    'costo_adicional_unitario' => 0.00,
                    'plazo_dias' => $index + 2,
                ]);
            }
        }

        $usuario = $db->table('usuarios')->select('id')->where('correo', 'admin@sipac.local')->get()->getRowArray();
        if ($db->table('movimientos_inventario')->countAllResults() === 0 && $usuario !== null) {
            $productos = $db->table('productos')->select('id')->orderBy('id', 'ASC')->get()->getResultArray();
            foreach ($productos as $index => $producto) {
                $db->table('movimientos_inventario')->insert([
                    'producto_id' => $producto['id'],
                    'usuario_id' => $usuario['id'],
                    'fecha' => date('Y-m-d'),
                    'tipo' => 'entrada',
                    'cantidad' => $index === 0 ? 35 : 8,
                    'motivo' => 'Saldo inicial de demostración',
                ]);
            }
        }
    }
}
