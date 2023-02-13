<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiSecretHeader extends Model
{
    use HasFactory;

    public function locker(){
        return $this->belongsTo(Locker::class,'locker_id','locker_id');
    }

    public static function search($search){
        if(empty($search)){
            return static::query();
        }else{
            return static::query()
                            ->where(function($query) use ($search){
                                $query->orWhere('key_title','like','%'.$search.'%')
                                ->whereRelation('locker','location_address','like','%'.$search.'%')
                                ->orWhere('api_auth','like','%'.$search.'%')
                                ->orWhere('locker_id','like','%'.$search.'%');
                            });
        }
    }
}
