<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserRolesTable extends Migration
{
    public function up()
    {
        // Define the User table
        $this->forge->addField([
            'user_role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],

            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],

            ]);
        
        $this->forge->addKey('user_role_id', TRUE);
        $this->forge->addForeignKey('user_id', 'User', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'Roles', 'role_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('User_Roles'); 
    }

    public function down()
    {
        $this->forge->dropTable('User_Roles');
    }
}
