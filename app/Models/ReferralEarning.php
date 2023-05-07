<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReferralEarning extends Model
{
    use HasFactory;

    public function referrer()
    {
        return $this->hasOne(User::class, 'referrer_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }


    public function scopeMyReferrer($query)
    {
        $query->where('referrer_id', Auth::user()->id);
    }
}
