<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guard = ['*'];

    public function lockers()
    {
        return $this->hasMany(Locker::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
    public function bookings(){
        return $this->hasMany(Booking::class,'company_id','company_id');
    }


    public static function search($search){
        if(empty($search)){
            return static::query();
        }else{
            return static::query()
                            ->where('soft_deleted_at',null)
                            ->where(function($query) use ($search){
                                $query->orWhere('company_name','like','%'.$search.'%')
                                ->orWhere('company_address','like','%'.$search.'%')
                                ->orWhere('company_contact_person_name','like','%'.$search.'%')
                                ->orWhere('company_contact_person_number','like','%'.$search.'%')
                                ->orWhere('company_email','like','%'.$search.'%');
                            });
        }
    }
}
