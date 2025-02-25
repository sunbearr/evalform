<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatQrCodesTable extends Migration
{
    public function up()
    {
                       
        $this->forge->addField([
            'qr_code_id' => [
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
            'qr_code_data' => [
                'type' => 'TEXT',
            ],
        ]);
        
        $this->forge->addKey('qr_code_id', TRUE);
        $this->forge->addForeignKey('survey_id', 'Surveys', 'survey_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('QR_Codes'); 
    }

    public function down()
    {
        $this->forge->dropTable('QR_Codes');
    }
}
