<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    
    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';

    protected $allowedFields = ['user_id','role','email', 'is_deleted','first_name', 'last_name', 'gender','password'];

}