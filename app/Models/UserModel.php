<?php

namespace App\Models; 

use CodeIgniter\Model; 

class UserModel extends Model 
{
    protected $table = 'User'; 
    protected $primaryKey = 'user_id'; 
    protected $allowedFields = ['username', 'email', 'phone', 'url', 'status']; 
    protected $returnType = 'array'; 
}