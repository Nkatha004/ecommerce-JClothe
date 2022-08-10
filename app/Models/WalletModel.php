<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table = 'tbl_wallet';
    protected $primaryKey = 'wallet_id';

    protected $allowedFields = ['wallet_id','customer_id', 'amount_available','created_at','updated_at','is_deleted'];
}