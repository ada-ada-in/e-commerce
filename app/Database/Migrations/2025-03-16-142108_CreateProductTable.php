<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'category_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'price' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'description' => ['type' => 'TEXT'],
            'stock' => ['type' => 'INT', 'constraint' => 11],
            'image_url' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true]
        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('product');

    }

    public function down()
    {
        $this->forge->dropTable('product');
    }
}
