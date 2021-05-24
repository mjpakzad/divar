<?php

namespace App\Listeners;

use App\Events\CommercialExpired;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sms;

class SendExpiredCommercial
{
    /**
     * Create the event listener.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommercialExpired  $event
     * @return void
     */
    public function handle(CommercialExpired $event)
    {
        $commercial = $event->commercial;
        $message = 'بانک آگهی
آگهی شما منقضی شد جهت تمدید اقدام کنید
با تشکر';
        Sms::send($message, $commercial->user->mobile);
    }
}
