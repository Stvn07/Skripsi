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
}
