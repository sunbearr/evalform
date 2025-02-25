<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResponsesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'response_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'question_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
        ]);
        
        $this->forge->addKey('response_id', TRUE);
        $this->forge->addForeignKey('question_id', 'Questions', 'question_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Responses'); 
        
    }

    public function down()
    {
        $this->forge->dropTable('Responses');
    }
}
