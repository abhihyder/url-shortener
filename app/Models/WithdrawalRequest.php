<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WithdrawalRequest extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function withdrawalMethod()
    {
        return $this->belongsTo(WithdrawalMethod::class);
    }


    public function scopeMyRequest($query)
    {
        $query->where(['user_id' => Auth::user()->id]);
    }
    public function scopeStatus($query, $status = [0])
    {
        $query->whereIn('status', $status);
    }
}
