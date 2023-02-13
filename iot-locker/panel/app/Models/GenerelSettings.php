<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerelSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_name',
        'setting_value'
    ];
    public function locker(){
        return $this->belongsTo(Locker::class);
    }
}
