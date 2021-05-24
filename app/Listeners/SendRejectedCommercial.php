<?php

namespace App\Listeners;

use App\Events\CommercialRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use SMS;

class SendRejectedCommercial
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommercialRejected  $event
     * @return void
     */
    public function handle(CommercialRejected $event)
    {
        $commercial = $event->commercial;
        $message = 'بانک آگهی
آگهی شما رد شد.
با تشکر
';
        Sms::send($message, $commercial->user->mobile);
    }
}
