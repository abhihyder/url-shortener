<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WithdrawalMethod extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeMyMethod($query)
    {
        $query->where('user_id', Auth::user()->id);
    }
}
