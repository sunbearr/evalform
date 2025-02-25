<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table = 'Questions'; // Set to your actual table name
    protected $primaryKey = 'question_id'; 
    protected $allowedFields = ['survey_id', 'question_type', 'order', 'question_text'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}