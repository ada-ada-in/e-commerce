<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDeliveryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'transactions_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tracking_number' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'address' => ['type' => 'VARCHAR', 'constraint' => 255],
            'status' => ['type' => 'ENUM', 'constraint' => ["order", "pickup", "send", "complete"], 'default' => 'pickup'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('transactions_id', 'transactions', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('delivery');

    }

    public function down()
    {
        $this->forge->dropTable('delivery');
    }
}
