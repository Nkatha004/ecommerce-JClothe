<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLoginModel extends Model
{
    
    protected $table = 'tbl_userlogins';
    protected $primaryKey = 'userlogin_id';

    protected $allowedFields = ['userlogin_id','user_id','user_ip','login_time','logout_time', 'is_deleted'];

}