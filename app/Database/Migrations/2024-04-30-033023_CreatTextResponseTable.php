<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatTextResponseTable extends Migration
{
    public function up()
    {
                       
        $this->forge->addField([
            'text_response_id' => [
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
            'text' => [
                'type' => 'TEXT',
            ],
        ]);
        
        $this->forge->addKey('text_response_id', TRUE);
        $this->forge->addForeignKey('response_id', 'Responses', 'response_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Text_Response'); 
    }

    public function down()
    {
        $this->forge->dropTable('Text_Response'); 
    }
}
