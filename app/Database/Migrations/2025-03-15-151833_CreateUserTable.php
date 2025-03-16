<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'  => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'name'  => ['type'  => 'VARCHAR', 'constraint' => 100],
            'email' => ['type'  => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'phone' => ['type'  => 'VARCHAR', 'constraint' => 15],
            'address' => ['type'  => 'VARCHAR', 'constraint' => 200],
            'role' => ['type'  => 'ENUM', 'constraint' => ["admin", "user"]],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
