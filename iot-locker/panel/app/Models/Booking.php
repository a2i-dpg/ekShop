<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['is_max_pickup_time_passed', 'assigned_person_to_return', 'customer_no'];
    protected $guard = [];

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id', 'box_key');
    }
    public function locker()
    {
        return $this->belongsTo(Locker::class, 'locker_id', 'locker_id');
    }
    public function rider()
    {
        return $this->belongsTo(Rider::class, 'booked_by_user_id', 'user_id');
    }
    public function returnedByRider()
    {
        return $this->belongsTo(Rider::class, 'collected_by', 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by_user_id', 'user_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function messageLog()
    {
        return $this->hasMany(messageLog::class, 'message_key','customer_sms_key')->latest(); //working
    }

    public static function search($search, $selectedDate)
    {
        return static::query()
            ->where('company_id', session('company_id'))
            ->when($search,function($query_search) use ($search){
                $query_search->where(function ($query) use ($search) {
                    $query->orWhere('booking_id', 'like', '%' . $search . '%')
                        ->orWhere('parcel_no', 'like', '%' . $search . '%')
                        ->orWhere('customer_no', 'like', '%' . $search . '%')
                        ->orWhere('locker_id', 'like', '%' . $search . '%')
                        ->orWhereRelation('locker', 'location_address', 'like', '%' . $search . '%')
                        ->orWhereRelation('rider', 'user_full_name', 'like', '%' . $search . '%')
                        ->orWhereRelation('box', 'box_no', 'like', '%' . $search . '%');
                });
            })
            ->when($selectedDate, function($query_date) use ($selectedDate){
                $query_date->whereDate('booked_at',$selectedDate);
            });
    }
    
    public static function searchBookingData($search)
    {
        if (empty($search)) {
            return static::query();
        } else {
            return static::query()
                ->where(function ($query) use ($search) {
                    $query->where('booking_id', 'like', '%' . $search . '%')
                        ->orWhereRelation('locker', 'location_address', 'like', '%' . $search . '%')
                        ->orWhereRelation('company', 'company_name', 'like', '%' . $search . '%')
                        ->orWhere('parcel_no', 'like', '%' . $search . '%')
                        ->orWhere('customer_no', 'like', '%' . $search . '%');
                });
        }
    }

    public static function searchBook($searchText)
    {
        if (empty($searchText)) {
            return static::query();
        } else {
            return static::query()
                ->Where('customer_no', 'like', '%' . $searchText . '%');
        }
    }
    public static function searchCompany($companyText)
    {
        if (empty($companyText)) {
            return static::query();
        } else {
            $find_company_id = Company::where('company_name', 'like', '%' . $companyText . '%')->get();
            $company_id = [];
            foreach ($find_company_id as $value) {
                $company_id[] = $value->company_id;
            }
            return static::query()
                ->WhereIn('company_id', $company_id);
        }
    }


    public static function searchBookingForCompanyReport($search, $search2)
    {
        return static::query()
            ->where('soft_deleted_at', null)
            ->where(function ($query) use ($search) {
                $query->where('booking_id', 'like', '%' . $search . '%')
                    ->orWhereRelation('locker', function ($q) use ($search) {
                        $q->where('location_address', 'like', '%' . $search . '%')
                            ->orWhere('locker_id', 'like', '%' . $search . '%')
                            ->orWhere('locker_code', 'like', '%' . $search . '%')
                            ->orWhere('location_landmark', 'like', '%' . $search . '%');
                    })
                    ->orWhereRelation('box', function ($q) use ($search) {
                        $q->where('box_key', 'like', '%' . $search . '%')
                            ->orWhere('box_no', 'like', '%' . $search . '%');
                    })
                    ->orWhereRelation('rider', function ($q) use ($search) {
                        $q->where('user_full_name', 'like', '%' . $search . '%')
                            ->orWhere('user_mobile_no', 'like', '%' . $search . '%');
                    })
                    ->orWhereRelation('company', 'company_name', 'like', '%' . $search . '%')
                    ->orWhere('parcel_no', 'like', '%' . $search . '%')
                    ->orWhere('customer_no', 'like', '%' . $search . '%')
                    ->orWhere('booking_company_otp', 'like', '%' . $search . '%');
            })
            ->where(function ($query) use ($search2) {
                $query->where('booking_id', 'like', '%' . $search2 . '%')
                    ->orWhereRelation('locker', function ($q) use ($search2) {
                        $q->where('location_address', 'like', '%' . $search2 . '%')
                            ->orWhere('locker_id', 'like', '%' . $search2 . '%')
                            ->orWhere('locker_code', 'like', '%' . $search2 . '%')
                            ->orWhere('location_landmark', 'like', '%' . $search2 . '%');
                    })
                    ->orWhereRelation('rider', function ($q) use ($search2) {
                        $q->where('user_full_name', 'like', '%' . $search2 . '%')
                            ->orWhere('user_mobile_no', 'like', '%' . $search2 . '%');
                    })
                    ->orWhereRelation('box', function ($q) use ($search2) {
                        $q->where('box_key', 'like', '%' . $search2 . '%')
                            ->orWhere('box_no', 'like', '%' . $search2 . '%');
                    })
                    ->orWhereRelation('company', 'company_name', 'like', '%' . $search2 . '%')
                    ->orWhere('parcel_no', 'like', '%' . $search2 . '%')
                    ->orWhere('customer_no', 'like', '%' . $search2 . '%')
                    ->orWhere('booking_company_otp', 'like', '%' . $search2 . '%');
            });
    }
    public static function searchBookingForCompanyReport2($search)
    {
        if (empty($search)) {
            return static::query();
        } else {
            return static::query()
                ->where('soft_deleted_at', null)
                ->where(function ($query) use ($search) {
                    $query->where('booking_id', 'like', '%' . $search . '%')
                        ->orWhereRelation('locker', function ($q) use ($search) {
                            $q->where('location_address', 'like', '%' . $search . '%')
                                ->orWhere('locker_id', 'like', '%' . $search . '%')
                                ->orWhere('locker_code', 'like', '%' . $search . '%')
                                ->orWhere('location_landmark', 'like', '%' . $search . '%');
                        })
                        ->orWhereRelation('box', function ($q) use ($search) {
                            $q->where('box_key', 'like', '%' . $search . '%')
                                ->orWhere('box_no', 'like', '%' . $search . '%');
                        })
                        ->orWhereRelation('company', 'company_name', 'like', '%' . $search . '%')
                        ->orWhere('parcel_no', 'like', '%' . $search . '%')
                        ->orWhere('customer_no', 'like', '%' . $search . '%')
                        ->orWhere('booking_company_otp', 'like', '%' . $search . '%');
                });
        }
    }
}
