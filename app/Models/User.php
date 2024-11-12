<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $guard_name = 'web';
    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'status',
        'first_name',
        'last_name',
        'phone',
        'province_id',
        'district_id',
        'commune_id',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
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
        ];
    }
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
