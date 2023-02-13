<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'log_location_id',
        'log_box_key',
        'log_event_category',
        'log_event_subcategory',
        'log_event_type',
        'log_event_description',
        'log_details',
        'log_is_synced',
        'created_by',
    ];

    public function box()
    {
        return $this->belongsTo(Box::class, 'log_box_key', 'box_key');
    }
    public function locker()
    {
        return $this->belongsTo(Locker::class, 'log_location_id', 'locker_id');
    }

    public static function searchLogData($search, $what, $detail, $who, $dateRange)
    {
        // empty($search)
        if (false) {
            return static::query();
        } else {
            return static::query()
                ->where(function ($query) use ($search, $what, $detail, $who, $dateRange) {

                    $query->when($what, function ($q, $what) {
                        $q->where('log_event_description', 'like', '%' . $what . '%');
                    })->when($detail, function ($q, $detail) {
                        $q->where('log_details', 'like', '%' . $detail . '%');
                    })->when($who, function ($q, $who) {
                        $q->where('log_details', 'like', '%' . $who . '%')
                            ->orWhere('created_by', 'like', '%' . $who . '%');
                    })->when($dateRange, function ($q, $dateRange) {
                        $q->whereBetween('created_at', $dateRange);
                    });
                });
        }
    }
}
