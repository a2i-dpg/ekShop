<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Helpers\SMS;
use App\Models\Message;
use Carbon\Carbon;

class MessageShootingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $msgInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msgInfo)
    {
        $this->msgInfo = $msgInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $queueMessageInfo = Message::find($this->msgInfo['id']);

        if ($queueMessageInfo->sms_is_sent == 1) {
            return true;
        }

        $response = SMS::sendSms($this->msgInfo['contact_no'], $this->msgInfo['smsBody']);

        if ($response->code === 200) {
            $smsResponse = $queueMessageInfo->update([
                'sms_is_sent' => 1,
                'sms_sent_time' => Carbon::now()
            ]);
        } else {
            $smsResponse = $queueMessageInfo->increment('counter_retry');
        }
    }
}
