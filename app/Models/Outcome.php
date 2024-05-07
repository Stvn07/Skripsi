<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    use HasFactory;
    protected $table = "outcome";
    protected $fillable = [
        'outcome_name',
        'outcome_date',
        'outcome_amount',
        'outcome_category'
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
