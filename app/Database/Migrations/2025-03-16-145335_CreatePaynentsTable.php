<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaynentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'transactions_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'payment_methode' => ['type' => 'VARCHAR', 'constraint' => 150],
            'payment_status' => ['type' => 'ENUM', 'constraint' => ["pending", "success", "failed"]],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('transactions_id', 'transactions', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('payment');

    }

    public function down()
    {
        $this->forge->dropTable('payment');
    }
}
