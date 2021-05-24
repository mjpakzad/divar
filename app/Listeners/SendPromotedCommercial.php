<?php

namespace App\Listeners;

use App\Events\CommercialPromoted;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sms;

class SendPromotedCommercial
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
     * @param  \App\Events\CommercialPromoted  $event
     * @return void
     */
    public function handle(CommercialPromoted $event)
    {
        $commercial = $event->commercial;
        $message = 'بانک آگهی
آگهی شما با موفقیت ارتقا یافت.
با تشکر
';
        Sms::send($message, $commercial->user->mobile);
    }
}
