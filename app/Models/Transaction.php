<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'price', 'reference', 'merchant_ref', 'status'
    ];

    protected $table = 'transactions';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
