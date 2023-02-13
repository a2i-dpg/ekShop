<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public function messages(){
        return $this->hasMany(MessageLog::class);
    }
    public function logs(){
        return $this->hasMany(Log::class);
    }
}
