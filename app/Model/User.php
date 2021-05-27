<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    // protected $with = ["city"];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getProfileImageAttribute()
    {
        return ($this->profile_picture) ? asset('uploads/profiles/' . $this->profile_picture) : asset('uploads/nouser.png');
    }


    public function user_role() {
        return $this->belongsToMany('App\Model\Role', 'user_roles');
    }

    public function roles() {
        return $this->belongsToMany('App\Model\Role', 'user_roles');
    }

    public function orders() {
        return $this->hasMany('App\Model\Order');
    }

    public function deliveredorders() {
        return $this->hasMany('App\Model\Order')->where('delivery_status','Delivered');
    }

    public function products() {
        return $this->belongsToMany('App\Model\Product','favourite_products')->where('favourite_products.status', 'AC');
    }

    public function fetchUsers($usertype) {

        $query = User::whereHas('user_role', function ($query) use ($usertype) {
            $query->where('role', $usertype);
        });
        $users = $query->where('status', '!=', 'DL')->orderBy('created_at', 'desc')->get();

        return $users;
    }
    
    public function scopeSearch( $query, $term ) 
    {
        return $query->where( 'name', 'like','%'.  $term . '%');
    }

    public function favorites() {
        return $this->belongsToMany('App\Model\Product','favourite_products')->with('brand','variations');
    }

}
