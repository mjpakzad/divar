<?php

namespace App\Listeners;

use App\Events\CommercialPublished;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendGreeting
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
        $message = '
        خانه کشتی داران‌؛ ورود شما به وب سایت https://kashtidaran.com را تبریک می‌گوییم. ثبت نام شما با موفقیت انجام شد. 
';
        send_sms($commercial->user->mobile, $message);
    }
}
