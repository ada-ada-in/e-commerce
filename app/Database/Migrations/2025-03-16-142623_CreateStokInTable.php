<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStokInTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'product_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'quantity' => ['type' => 'INT', 'constraint' => 11],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('product_id', 'product', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('stok_in');

    }

    public function down()
    {
        $this->forge->dropTable('stok_in');
    }
}
