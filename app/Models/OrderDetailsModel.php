<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailsModel extends Model
{
    protected $table = 'tbl_orderdetails';
    protected $primaryKey = 'orderdetails_id';

    protected $allowedFields = ['orderdetails_id','order_id','product_id','product_price','order_quantity',
    'orderdetails_total','created_at','updated_at','is_deleted'];
}