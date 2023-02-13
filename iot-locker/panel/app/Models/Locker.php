<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    // protected $guard = [];

    protected $fillable = ["locker_code", 'location_landmark', 'location_is_active'];


    // Global Scope
    public function scopeActive($q)
    {
        return $q->where('location_is_active', 1);
    }

    // User: Admin & Agent
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_active')
            ->withTimestamps();
    }

    // Rider: Delivery Man
    public function riders()
    {
        return $this->belongsToMany(Rider::class)
            ->where('user_is_active', 1)
            ->withPivot('is_active')
            ->withTimestamps();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function boxes()
    {
        return $this->hasMany(Box::class, 'locker_id', 'locker_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'locker_id', 'locker_id');
    }

    public function setting()
    {
        return $this->hasMany(GenerelSettings::class);
    }
    public function message()
    {
        return $this->hasMany(MessageLog::class, 'locker_id', 'locker_id');
    }
    public function apiSecretHeader()
    {
        return $this->hasOne(ApiSecretHeader::class, 'locker_id', 'locker_id');
    }


    public static function search($search)
    {

        if (empty($search)) {
            return static::query();
        } else {
            return static::query()
                ->where('location_is_active', 1)
                ->where(function ($q) use ($search) {
                    $q->where('locker_id', 'like', '%' . $search . '%')
                        ->orWhere('locker_code', 'like', '%' . $search . '%')
                        ->orWhere('location_ids', 'like', '%' . $search . '%')
                        ->orWhere('location_landmark', 'like', '%' . $search . '%')
                        ->orWhere('location_address', 'like', '%' . $search . '%');
                });
        }
    }

    public function event_logs()
    {
        return $this->hasMany(EventLog::class, 'log_location_id', 'locker_id')->latest(); //working
    }
}
