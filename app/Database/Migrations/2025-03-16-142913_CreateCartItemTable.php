<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'product_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'quantity' => ['type' => 'INT', 'constraint' => 11],
            'total_price' => ['type' => 'INT', 'constraint' => 11],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('product_id', 'product', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('cart_items');

    }

    public function down()
    {
        $this->forge->dropTable('cart_items');
    }
}
