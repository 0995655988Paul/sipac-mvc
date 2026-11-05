<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Esquema mínimo operativo del core aprobado de SIPAC.
 * Las relaciones se expresan con claves foráneas para que el servidor
 * tampoco permita referencias huérfanas enviadas manualmente.
 */
class CrearTablasSIPAC extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nombre' => ['type' => 'VARCHAR', 'constraint' => 120],
            'correo' => ['type' => 'VARCHAR', 'constraint' => 254],
            'clave_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'rol' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'ADMIN'],
            'activo' => ['type' => 'BOOLEAN', 'default' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('correo');
        $this->forge->createTable('usuarios', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'codigo' => ['type' => 'VARCHAR', 'constraint' => 20],
            'nombre' => ['type' => 'VARCHAR', 'constraint' => 120],
            'unidad' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'unidades'],
            'stock_seguridad' => ['type' => 'INTEGER', 'constraint' => 11, 'default' => 0],
            'prioridad' => ['type' => 'INTEGER', 'constraint' => 1, 'default' => 1],
            'activo' => ['type' => 'BOOLEAN', 'default' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('codigo');
        $this->forge->createTable('productos', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'razon_social' => ['type' => 'VARCHAR', 'constraint' => 160],
            'identificacion_fiscal' => ['type' => 'VARCHAR', 'constraint' => 13],
            'contacto' => ['type' => 'VARCHAR', 'constraint' => 120],
            'correo' => ['type' => 'VARCHAR', 'constraint' => 254],
            'telefono' => ['type' => 'VARCHAR', 'constraint' => 20],
            'activo' => ['type' => 'BOOLEAN', 'default' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('identificacion_fiscal');
        $this->forge->createTable('proveedores', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'periodo' => ['type' => 'VARCHAR', 'constraint' => 7],
            'monto_autorizado' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('periodo');
        $this->forge->createTable('presupuestos', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'proveedor_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'fecha_emision' => ['type' => 'DATE'],
            'valida_hasta' => ['type' => 'DATE'],
            'estado' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'VIGENTE'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('proveedor_id');
        $this->forge->addForeignKey('proveedor_id', 'proveedores', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('cotizaciones', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'cotizacion_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'producto_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'cantidad_disponible' => ['type' => 'INTEGER', 'constraint' => 11],
            'precio_unitario' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'costo_adicional_unitario' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'plazo_dias' => ['type' => 'INTEGER', 'constraint' => 5, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('cotizacion_id');
        $this->forge->addKey('producto_id');
        $this->forge->addForeignKey('cotizacion_id', 'cotizaciones', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('detalle_cotizaciones', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'producto_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'usuario_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'detalle_recepcion_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'fecha' => ['type' => 'DATE'],
            'tipo' => ['type' => 'VARCHAR', 'constraint' => 20],
            'cantidad' => ['type' => 'INTEGER', 'constraint' => 11],
            'motivo' => ['type' => 'VARCHAR', 'constraint' => 180],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('producto_id');
        $this->forge->addKey('usuario_id');
        $this->forge->addUniqueKey('detalle_recepcion_id');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('movimientos_inventario', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'presupuesto_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'usuario_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'fecha_corte' => ['type' => 'DATE'],
            'fecha_generacion' => ['type' => 'DATETIME'],
            'estado' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'BORRADOR'],
            'parametros_json' => ['type' => 'TEXT'],
            'version_metodo' => ['type' => 'VARCHAR', 'constraint' => 40],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('presupuesto_id');
        $this->forge->addKey('usuario_id');
        $this->forge->addForeignKey('presupuesto_id', 'presupuestos', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('planes_compra', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'plan_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'producto_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'detalle_cotizacion_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'consumo_estimado' => ['type' => 'INTEGER', 'constraint' => 11],
            'stock_corte' => ['type' => 'INTEGER', 'constraint' => 11],
            'pendiente_a_tiempo' => ['type' => 'INTEGER', 'constraint' => 11, 'default' => 0],
            'necesidad' => ['type' => 'INTEGER', 'constraint' => 11],
            'cantidad_sugerida' => ['type' => 'INTEGER', 'constraint' => 11],
            'costo_estimado' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'fecha_necesidad' => ['type' => 'DATE'],
            'prioridad_snapshot' => ['type' => 'INTEGER', 'constraint' => 1],
            'motivo' => ['type' => 'VARCHAR', 'constraint' => 240],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('plan_id');
        $this->forge->addKey('producto_id');
        $this->forge->addUniqueKey(['plan_id', 'producto_id']);
        $this->forge->addForeignKey('plan_id', 'planes_compra', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('detalle_cotizacion_id', 'detalle_cotizaciones', 'id', 'SET NULL', 'RESTRICT');
        $this->forge->createTable('detalles_plan', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'plan_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'nombre' => ['type' => 'VARCHAR', 'constraint' => 100],
            'variacion_consumo_pct' => ['type' => 'DECIMAL', 'constraint' => '6,2', 'default' => 0],
            'variacion_precio_pct' => ['type' => 'DECIMAL', 'constraint' => '6,2', 'default' => 0],
            'retraso_dias' => ['type' => 'INTEGER', 'constraint' => 5, 'default' => 0],
            'costo_estimado' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'brecha' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'resultado_json' => ['type' => 'TEXT'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('plan_id');
        $this->forge->addForeignKey('plan_id', 'planes_compra', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('escenarios', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'escenario_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'producto_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'tipo' => ['type' => 'VARCHAR', 'constraint' => 30],
            'descripcion' => ['type' => 'VARCHAR', 'constraint' => 240],
            'evidencia' => ['type' => 'VARCHAR', 'constraint' => 240],
            'impacto_estimado' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'accion_sugerida' => ['type' => 'VARCHAR', 'constraint' => 240],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('escenario_id');
        $this->forge->addKey('producto_id');
        $this->forge->addForeignKey('escenario_id', 'escenarios', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'SET NULL', 'RESTRICT');
        $this->forge->createTable('riesgos', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'proveedor_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'presupuesto_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'plan_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'aprobado_por' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'fecha_emision' => ['type' => 'DATE'],
            'fecha_prometida' => ['type' => 'DATE'],
            'estado' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'EMITIDA'],
            'total' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('proveedor_id');
        $this->forge->addKey('presupuesto_id');
        $this->forge->addKey('plan_id');
        $this->forge->addForeignKey('proveedor_id', 'proveedores', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('presupuesto_id', 'presupuestos', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('plan_id', 'planes_compra', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('aprobado_por', 'usuarios', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('ordenes_compra', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'orden_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'producto_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'cantidad' => ['type' => 'INTEGER', 'constraint' => 11],
            'precio_unitario' => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'costo_adicional_unitario' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('orden_id');
        $this->forge->addKey('producto_id');
        $this->forge->addForeignKey('orden_id', 'ordenes_compra', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('detalles_orden', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'orden_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'usuario_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'fecha' => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('orden_id');
        $this->forge->addForeignKey('orden_id', 'ordenes_compra', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('recepciones', true);

        $this->forge->addField([
            'id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'recepcion_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'detalle_orden_id' => ['type' => 'INTEGER', 'constraint' => 11, 'unsigned' => true],
            'cantidad' => ['type' => 'INTEGER', 'constraint' => 11],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('recepcion_id');
        $this->forge->addKey('detalle_orden_id');
        $this->forge->addUniqueKey(['recepcion_id', 'detalle_orden_id']);
        $this->forge->addForeignKey('recepcion_id', 'recepciones', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('detalle_orden_id', 'detalles_orden', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('detalles_recepcion', true);
    }

    public function down()
    {
        foreach (['detalles_recepcion', 'recepciones', 'detalles_orden', 'ordenes_compra', 'riesgos', 'escenarios', 'detalles_plan', 'planes_compra', 'movimientos_inventario', 'detalle_cotizaciones', 'cotizaciones', 'presupuestos', 'proveedores', 'productos', 'usuarios'] as $tabla) {
            $this->forge->dropTable($tabla, true);
        }
    }
}
