<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'role_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

            ]);
        
        $this->forge->addKey('role_id', TRUE); // Set user_id as primary key
        $this->forge->createTable('Roles'); // Create the User table
    }

    public function down()
    {
        $this->forge->dropTable('Roles');
    }
}
