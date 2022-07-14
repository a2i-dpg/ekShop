<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Mail\InvoiceEmailManager;
use Mail;
use App\Models\User;

class CartEmailListener implements ShouldQueue
{
    public function handle($event)
    {
        //sleep(10);
        $array['view'] = 'emails.invoice';
        $array['subject'] = translate('Your order has been placed') . ' - ' . $event->order->code;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['order'] = $event->order;
        try {
            Mail::to($event->order->user->email)->queue(new InvoiceEmailManager($array));
            Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));

        } catch (\Exception $e) {

        }
    }
}
