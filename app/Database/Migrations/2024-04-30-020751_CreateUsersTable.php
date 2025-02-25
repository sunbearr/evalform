<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        // Define the User table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'BOOLEAN',
            ],
        ]);
        
        $this->forge->addKey('user_id', TRUE); // Set user_id as primary key
        $this->forge->createTable('User'); // Create the User table
    }

    public function down()
    {
        // Drop the User table if needed
        $this->forge->dropTable('User');
    }
}