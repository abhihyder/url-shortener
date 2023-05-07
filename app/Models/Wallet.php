<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function scopeMyWallet($query)
    {
        $query->where('user_id', Auth::user()->id);
    }
}
