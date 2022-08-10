<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiUsersModel extends Model
{
    protected $table = 'tbl_apiusers';
    protected $primaryKey = 'apiuser_id';

    protected $allowedFields = ['apiuser_id', 'username','key','created_at','updated_on','added_by','is_deleted'];
}