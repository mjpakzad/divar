<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'mobile', 'email', 'phone', 'password', 'occupation', 'city_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function logins()
    {
        return $this->hasMany(LoginLog::class);
    }
    
    public function city() 
    {
        return $this->belongsTo(City::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function commercials()
    {
        return $this->hasMany(Commercial::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Commercial::class, 'bookmarks');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function twoFactorTokens()
    {
        return $this->hasMany(TwoFactor::class);
    }

    public function twoFactorCode()
    {
        return $this->twoFactorTokens()->latest()->first();
    }
    
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
