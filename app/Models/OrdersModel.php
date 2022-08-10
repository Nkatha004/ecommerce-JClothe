<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table = 'tbl_order';
    protected $primaryKey = 'order_id';

    protected $allowedFields = ['order_id','customer_id', 'order_amount','order_status','payment_type', 'created_at','updated_at', 'added_by','is_deleted'];
}