<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstBalance extends Model
{
    use HasFactory;
    protected $table = "first_balance";

    protected $fillable = [
        'first_balance_amount',
    ];

    public function totalBalance()
    {
        return $this->hasMany(TotalBalance::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
