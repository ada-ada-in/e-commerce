<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'total_price' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'status'      => ['type' => 'ENUM', 'constraint' => ['pending', 'paid', 'canceled'], 'default' => 'pending'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('transactions');

    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
