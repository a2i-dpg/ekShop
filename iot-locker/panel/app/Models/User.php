<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'email',
        'password',
    ];


    public function role(){
        return $this->belongsTo(Role::class);
    }

    // public function bookings(){
    //     return $this->hasMany(Booking::class,'user_id','booked_by_user_id');
    // }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 

    public function lockers()
    {
        return $this->belongsToMany(Locker::class)
            ->where('location_is_active',1)
            ->withPivot('is_active')
            ->withTimestamps();
    }

    // Rider: Delivery Man
    public function riders()
    {
        return $this->belongsToMany(Rider::class)
        ->withPivot('is_active')
        ->withTimestamps();
    }

    public static function search($search,$roleId){
        if(empty($search)){
            return static::query();
        }else{
            return static::query()
                        ->where('role_id',$roleId)
                        ->where(function($q) use ($search){
                            $q->where('user_full_name','like','%'.$search.'%')
                                ->orWhere('user_mobile_no','like','%'.$search.'%')
                                ->orWhere('email','like','%'.$search.'%')
                                ->orWhere('user_address','like','%'.$search.'%');
                        });
                        
        }
    }

}
