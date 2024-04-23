<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = "transaction";
    protected $fillable = [
        'transaction_date',
        'transaction_amount',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Income()
    {
        return $this->belongsTo(Income::class);
    }

    public function Outcome()
    {
        return $this->belongsTo(Outcome::class);
    }
}
