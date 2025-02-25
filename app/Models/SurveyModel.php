<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyModel extends Model
{
    protected $table = 'Surveys'; // Set to your actual table name
    protected $primaryKey = 'survey_id'; 
    protected $allowedFields = ['user_id', 'title', 'description', 'status'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}