<?php

namespace App\Models;

use CodeIgniter\Model;

class ResponseModel extends Model
{
    protected $table = 'Responses'; // Set to your actual table name
    protected $primaryKey = 'response_id'; 
    protected $allowedFields = ['question_id', 'text'];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}