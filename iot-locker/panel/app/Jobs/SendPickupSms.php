<?php

namespace App\Jobs;

use App\Helpers\SendSms;
use App\Models\MessageLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPickupSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $this->details['mobile'] = '0161236377';
        $response = SendSms::sendSms($this->details['mobile'],$this->details['body']);
        $response = json_decode($response);

        if($response->code === 200){
            $sms = MessageLog::where('id',$this->details['id'])->update(array('is_sent'=>1,'sent_time'=>Carbon::now()));
        }
        
    }
}
