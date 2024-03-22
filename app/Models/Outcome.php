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
    ];

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }
}
