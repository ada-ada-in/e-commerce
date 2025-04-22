<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionTable extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'total_price' => [
                'type'       => 'INT',
                'constraint' => 11
            ],
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 150
            ],
            'snap_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'settlement', 'deny', 'cancel', 'expire', 'failure', 'refund', 'partial_refund', 'chargeback'],
                'default'    => 'pending'
            ],
            'fraud_status' => [
                'type'       => 'ENUM',
                'constraint' => ['accept', 'challenge', 'deny'],
                'null'       => true
            ],
            'expire_time' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        
        $this->forge->addKey('id', true); 

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('transactions');

    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
