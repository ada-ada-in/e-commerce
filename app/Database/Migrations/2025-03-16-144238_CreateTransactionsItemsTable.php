<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'product_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'transactions_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'price' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'quantity' => ['type' => 'INT', 'constraint' => 11],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('product_id', 'product', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('transactions_id', 'transactions', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('transactions_items');

    }

    public function down()
    {
        $this->forge->dropTable('transactions_items');
    }
}
