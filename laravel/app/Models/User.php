<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Favorite;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    public $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $newRole = Role::firstOrCreate(['name' => 'new', 'guard_name' => 'web']);
            $user->assignRole($newRole);
        });
    }

    public function subscription()
    {
        $user = Auth::user();
        $newRole = Role::find('new');
        
        if ($user->hasRole($newRole->name)) {
            $removeNew = Role::where('name', 'new')->first();
            $addPay = Role::firstOrCreate(['name' => 'pay', 'guard_name' => 'web']);
    
            if ($removeNew) {
                $user->removeRole($removeNew);
                $user->assignRole($addPay);
            }
        }
    }
    




    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function user()
    {
        return $this->hasMany(Review::class, 'author_id');
    }

    public function favoritedM()
    {
        return $this->belongsToMany(Movie::class, 'favorites');
    }

    public function favoritedS()
    {
        return $this->belongsToMany(Serie::class, 'favorites');
    }

    public function favoritedE()
    {
        return $this->belongsToMany(Episode::class, 'favorites');
    }
}
