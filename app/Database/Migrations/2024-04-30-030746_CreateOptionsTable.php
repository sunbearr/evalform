<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOptionsTable extends Migration
{
    public function up()
    {
                       
        $this->forge->addField([
            'option_id' => [
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
            'option_text' => [
                'type' => 'TEXT',
            ],
            'order' => [
                'type' => 'VARCHAR',
                'constraint' => '255', // might need to be larger
            ],
            'is_correct' => [
                'type' => 'BOOLEAN',
            ],
        ]);
        
        $this->forge->addKey('option_id', TRUE);
        $this->forge->addForeignKey('question_id', 'Questions', 'question_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Options'); 
    }

    public function down()
    {
        $this->forge->dropTable('Options');
    }
}
