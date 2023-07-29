<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'users_id', 'event_date', 'name', 'address', 'detail_order', 'phone', 'payment_url', 'total_price', 'status',
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'transactions_id', 'id');
    }

    public function transaction_details()
    {
        return $this->hasMany(Review::class, 'transactions_id', 'id');
    }
}
