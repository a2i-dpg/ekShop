<?php

namespace App\Http\Resources\V2;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryBoyPurchaseHistoryMiniCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $shipping_address = json_decode($data->shipping_address,true);
                $location_available = false;
                $lat = 90.99;
                $lang = 180.99;

                if(isset($shipping_address['lat_lang'])){
                    $location_available = true;
                    $exploded_lat_lang = explode(',',$shipping_address['lat_lang']);
                    $lat = floatval($exploded_lat_lang[0]);
                    $lang = floatval($exploded_lat_lang[1]);
                }
                return [
                    'id' => $data->id,
                    'code' => $data->code,
                    'user_id' => intval($data->user_id),
                    'payment_type' => ucwords(str_replace('_', ' ', $data->payment_type)) ,
                    'payment_status' => $data->payment_status,
                    'payment_status_string' => ucwords(str_replace('_', ' ', $data->payment_status)),
                    'delivery_status' => $data->delivery_status,
                    'delivery_status_string' => $data->delivery_status == 'pending'? "Order Placed" : ucwords(str_replace('_', ' ',  $data->delivery_status)),
                    'grand_total' => format_price($data->grand_total) ,
                    'date' => Carbon::createFromFormat('Y-m-d H:i:s',$data->delivery_history_date)->format('d-m-Y'),
                    'cancel_request' => $data->cancel_request == 1,
                    'delivery_history_date' => $data->delivery_history_date,
                    'location_available' => $location_available,
                    'lat' => $lat,
                    'lang' => $lang,
                    'links' => [
                        'details' => ""
                    ]
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
