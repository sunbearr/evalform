<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'question_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'survey_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'question_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'question_text' => [
                'type' => 'TEXT',
            ],
        ]);
        
        $this->forge->addKey('question_id', TRUE);
        $this->forge->addForeignKey('survey_id', 'Surveys', 'survey_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Questions'); 
    }

    public function down()
    {
        $this->forge->dropTable('Questions');
    }
}
