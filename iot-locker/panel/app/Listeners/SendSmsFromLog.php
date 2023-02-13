<?php

namespace App\Listeners;

use App\Events\SmsCheck;
use App\Helpers\SendSms;
use App\Jobs\SendPickupSms;
use App\Models\MessageLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsFromLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SmsCheck  $event
     * @return void
     */
    public function handle(SmsCheck $event)
    {
        $sms = MessageLog::all();
        foreach ($sms as $value) {
            if($value->is_sent !=1 && $value->retry_count<11){
                MessageLog::where('id',$value->id)->update(array('retry_count'=>$value->retry_count+1));
                $details = [
                    'body'=>$value->sms_text,
                    'mobile'=>$value->receiver_number,
                    'id'=>$value->id
                ];
                SendPickupSms::dispatch($details);
            }
        }
    }
}
