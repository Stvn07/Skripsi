<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalBalance extends Model
{
    use HasFactory;
    protected $table = "total_balance";
    protected $fillable = [
        'total_balance_date',
        'total_balance_amount',
    ];

    public function firstBalance()
    {
        return $this->belongsTo(FirstBalance::class);
    }

    public function Income()
    {
        return $this->belongsTo(Income::class);
    }

    public function Outcome()
    {
        return $this->belongsTo(Outcome::class);
    }

    public function Transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
