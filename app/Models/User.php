<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'name_ar',
        'email',
        'password',
        'user_type',
        'phone',
        'status',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function wallet()
    {
        return $this->hasOne(UserWallet::class);
    }

    public function overTimes()
    {
        return $this->hasMany(OverTime::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class)->orderBy('created_at', 'desc');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class)->orderBy('created_at', 'desc');
    }
}
