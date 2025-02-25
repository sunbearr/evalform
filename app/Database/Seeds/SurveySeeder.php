<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SurveySeeder extends Seeder
{
    public function run()
    {
        // Insert sample data into the User table for multiple users
        $survey_data = [
            [
                'user_id' => 7,
                'title' => 'Ancient History Survey',
                'description' => 'Testing my students knowledge of ancient history :)',
                'status' => 1
            ]
        ];

        $surveyIds = [];

        foreach ($survey_data as $survey) {
            $this->db->table('Surveys')->insert($survey);
            $surveyIds[] = $this->db->insertID();
        }
    }
}
