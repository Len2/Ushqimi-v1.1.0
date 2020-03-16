<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password',
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

    // Relationships with User Table


    public function address(){
        return $this->hasOne('App\Address');
    }


//    public function role()
//    {
//        return $this->belongsToMany(Role::class, 'role_user');
//    }

    /*              Lendrit
    public function userRoles(){
        return $this->hasMany('App\UserRole');
    }
    */

    public function reservation(){
        return $this->hasMany('App\Reservation');
    }   

    public function order(){
        return $this->hasMany('App\Order');
    } 

    public function invoice(){
        return $this->hasMany('App\Invoice');
    } 
    
    public function pageFollowers(){
        return $this->hasMany('App\PageFollowers');
    }  
    
    public function galleryImages(){
        return $this->hasMany('App\GalleryImage');
    }   

    // JWT Functions
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return[];
    }
}
