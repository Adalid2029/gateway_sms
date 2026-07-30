<?php

declare(strict_types=1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventoPushFcmGatewayTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id_evento_push_fcm_gateway' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_dispositivo_proveedor_gateway' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'id_users_proveedor_sms' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'identificador_evento' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tipo_evento' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'estado_envio' => [
                'type' => 'ENUM',
                'constraint' => ['PENDIENTE', 'ACEPTADO_FCM', 'RECIBIDO_DISPOSITIVO', 'ERROR'],
                'default' => 'PENDIENTE',
            ],
            'id_mensaje_firebase' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'codigo_error' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'mensaje_error' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'enviado_en' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'recibido_en' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id_evento_push_fcm_gateway', true);
        $this->forge->addUniqueKey('identificador_evento', 'uq_fcm_identificador_evento');
        $this->forge->addKey('id_dispositivo_proveedor_gateway', false, false, 'idx_fcm_dispositivo');
        $this->forge->addKey('id_users_proveedor_sms', false, false, 'idx_fcm_proveedor');
        $this->forge->addForeignKey(
            'id_dispositivo_proveedor_gateway',
            'dispositivo_proveedor_gateway',
            'id_dispositivo_proveedor_gateway',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->addForeignKey(
            'id_users_proveedor_sms',
            'proveedor_sms',
            'id_users_proveedor_sms',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('evento_push_fcm_gateway', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('evento_push_fcm_gateway', true);
    }
}
