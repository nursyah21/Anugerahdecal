<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;
    protected $fillable = ['order_id', 'user_id','name', 'address', 'number_phone','bukti_transfer', 'detail_transaksi','total_price','status'];
}
