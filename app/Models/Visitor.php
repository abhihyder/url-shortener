<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Visitor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shortenUrl()
    {
        return $this->belongsTo(ShortenUrl::class);
    }
    
    public function scopeMyVisitor($query)
    {
        $query->where('user_id', Auth::user()->id);
    }
}
