<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcOrder extends Model
{
    use HasFactory;

    protected $table = 'ec_orders';
protected $fillable = [
        'processed_status',
        'store_id',
        'user_id',
        'kd_contact_id',
        // other fields...
    ];


public function address()
{
    return $this->hasOne(EcOrderAddress::class, 'order_id', 'id');
}

public function store()
{
    return $this->belongsTo(MpStore::class, 'store_id');
}
}
