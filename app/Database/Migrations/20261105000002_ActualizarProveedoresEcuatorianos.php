<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/** Actualiza únicamente los dos registros ficticios creados por el seeder inicial. */
class ActualizarProveedoresEcuatorianos extends Migration
{
    public function up()
    {
        $this->db->table('proveedores')->where('identificacion_fiscal', '1790016919001')->update([
            'razon_social' => 'PROCESADORA NACIONAL DE ALIMENTOS PRONACA C.A. · Mr. Pollo / Indaves',
            'identificacion_fiscal' => '1790319857001',
            'contacto' => 'Ventas PRONACA',
            'correo' => 'ventas@pronaca.test',
        ]);
        $this->db->table('proveedores')->where('identificacion_fiscal', '0990004196001')->update([
            'razon_social' => 'LA FABRIL S.A. · La Favorita / Girasol',
            'identificacion_fiscal' => '1390012949001',
            'contacto' => 'Ventas La Fabril',
            'correo' => 'comercial@lafabril.test',
        ]);
    }

    public function down()
    {
        $this->db->table('proveedores')->where('identificacion_fiscal', '1790319857001')->update([
            'razon_social' => 'Distribuidora Andina S.A.',
            'identificacion_fiscal' => '1790016919001',
            'contacto' => 'María Paredes',
            'correo' => 'ventas@andina.test',
        ]);
        $this->db->table('proveedores')->where('identificacion_fiscal', '1390012949001')->update([
            'razon_social' => 'Comercial Sierra Norte',
            'identificacion_fiscal' => '0990004196001',
            'contacto' => 'Luis Cedeño',
            'correo' => 'compras@sierra.test',
        ]);
    }
}
