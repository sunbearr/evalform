<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSurveysTable extends Migration
{
    public function up()
    {
               
        $this->forge->addField([
            'survey_id' => [
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
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '255', // might need to be larger
            ],
            'status' => [
                'type' => 'BOOLEAN',
            ],
        ]);
        
        $this->forge->addKey('survey_id', TRUE);
        $this->forge->addForeignKey('user_id', 'User', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Surveys'); 
    }

    public function down()
    {
        $this->forge->dropTable('Surveys');
    }
}
