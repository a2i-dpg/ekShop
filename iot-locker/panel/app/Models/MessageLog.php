<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_key',
        'receiver_number',
        'sms_text',
        'is_sent',
        'retry_count',
        'resend_count',
        'event_name',
        'sent_time',
        'locker_id'
    ];
    public function event(){
        return $this->belongsTo(Event::class);
    }


    public function locker(){
        return $this->belongsTo(Locker::class,'locker_id','locker_id');
    }

    public function booking(){
        return $this->belongsTo(Booking::class,'message_key','customer_sms_key');
    }


    // Search Function

    public static function search($search){
        if(empty($search)){
            return static::query();
        }else{
            return static::query()
                        ->where(function($query) use ($search){
                            $query->where('sms_text','like','%'.$search.'%')
                            ->orWhere('receiver_number','like','%'.$search.'%')
                            ->orWhereRelation('locker','location_address','like','%'.$search.'%');
                        });
        }
        
    }
}
