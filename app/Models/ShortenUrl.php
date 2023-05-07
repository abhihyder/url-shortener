<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShortenUrl extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function setExpireDateAttribute($value)
    {
        if ($value) $this->attributes['expire_date'] = date('Y-m-d 23:59:59', strtotime($value));
    }

    public function scopeMyShortenUrl($query)
    {
        $query->where(['user_id' => Auth::user()->id]);
    }
}
