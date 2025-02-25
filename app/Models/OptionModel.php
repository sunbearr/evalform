<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $table = 'Options'; // Set to your actual table name
    protected $primaryKey = 'option_id'; 
    protected $allowedFields = ['question_id', 'option_text', 'order', 'is_correct'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}