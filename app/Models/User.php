<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_full_name',
        'user_email',
        'password',
        'user_address',
        'user_phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function totalBalance()
    {
        return $this->hasMany(TotalBalance::class);
    }

    public function firstBalance()
    {
        return $this->hasMany(FirstBalance::class);
    }

    public function incomes()
    {
        return $this->hasMany(Transaction::class, 'user_id')->where('transaction_type', 'income');
    }

    public function outcomes()
    {
        return $this->hasMany(Transaction::class, 'user_id')->where('transaction_type', 'outcome');
    }
}
