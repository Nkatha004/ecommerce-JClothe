<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'tbl_paymenttypes';
    protected $primaryKey = 'paymenttype_id';

    protected $allowedFields = ['paymenttype_id','paymenttype_name','description','is_deleted'];
}