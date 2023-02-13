<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;
    // protected $fillable=[
    //     'locker_id',
    //     'box_no',
    //     'box_size',
    //     'box_key',
    //     'box_is_enable',
    //     'box_is_online',
    //     'box_is_in_maintenance',
    //     'box_is_booked',
    //     'box_is_closed',
    //     'booking_id'
    // ];
    protected $guard = [];


    public function locker()
    {
        return $this->belongsTo(Locker::class, 'locker_id', 'locker_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'box_id', 'box_key')->latest(); //working
    }

    public function event_logs()
    {
        return $this->hasMany(EventLog::class, 'log_box_key', 'box_key')->latest(); //working
    }

    public static function search($search)
    {
        if (empty($search)) {
            return static::query();
        } else {
            return static::query()
                ->where(function ($query) use ($search) {
                    $query->where('locker_id', 'like', '%' . $search . '%')
                        ->orWhere('box_key', 'like', '%' . $search . '%')
                        ->orWhere('box_no', 'like', '%' . $search . '%')
                        ->orWhere('box_size', 'like', '%' . $search . '%');
                });
        }
    }
}
