<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMcqChoiceTable extends Migration
{
    public function up()
    {
                       
        $this->forge->addField([
            'mcq_choice_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'response_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'option_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
        ]);
        
        $this->forge->addKey('mcq_choice_id', TRUE);
        $this->forge->addForeignKey('response_id', 'Responses', 'response_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('option_id', 'Options', 'option_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mcq_choice'); 
    }

    public function down()
    {
        $this->forge->dropTable('mcq_choice');
    }
}
