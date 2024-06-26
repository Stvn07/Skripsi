<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $table = "income";
    protected $fillable = [
        'income_name',
        'income_date',
        'income_amount',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function totalBalance()
    {
        return $this->hasMany(TotalBalance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
