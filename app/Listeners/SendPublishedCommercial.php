<?php

namespace App\Listeners;

use App\Events\CommercialPublished;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sms;

class SendPublishedCommercial
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
     * @param  \App\Events\CommercialPublished  $event
     * @return void
     */
    public function handle(CommercialPublished $event)
    {
        $commercial = $event->commercial;
        $message = 'بانک آگهی
آگهی شما با موفقیت انتشار یافت.
با تشکر
';
        Sms::send($message, $commercial->user->mobile);
    }
}
