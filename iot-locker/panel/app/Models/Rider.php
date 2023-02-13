<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_name',
        'email',
        'password',
    ];
    protected $hidden = [
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function role(){
        return $this->belongsTo(Role::class);
    }


    public function lockers()
    {
        return $this->belongsToMany(Locker::class)
            ->withPivot('is_active')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_active')
            ->withTimestamps();
    }

    public function bookings(){
        return $this->hasMany(Booking::class,'booked_by_user_id','user_id');
    }
    public function returnedBookings(){
        return $this->hasMany(Booking::class,'collected_by','user_id');
    }

    public static function search($search){
        
        if(empty($search)){
            return static::query();
        }else{
            return static::query()
                        ->where(function($q) use($search){
                            $q->where('user_full_name','like','%'.$search.'%')
                            ->orWhere('user_mobile_no','like','%'.$search.'%')
                            ->orWhere('email','like','%'.$search.'%')
                            ->orWhere('user_address','like','%'.$search.'%');
                        });
        }
    }
}
