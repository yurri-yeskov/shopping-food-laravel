<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    // protected $with = ["city"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user_role() {
        return $this->belongsToMany('App\Model\Role', 'user_roles');
    }

    public function roles() {
        return $this->belongsToMany('App\Model\Role', 'user_roles');
    }

    public function orders() {
        return $this->hasMany('App\Model\Order');
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

}
