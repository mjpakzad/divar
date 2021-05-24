<?php

namespace App\Listeners;

use App\Events\CommercialReportaged;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sms;

class SendReportagedCommercial
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
     * @param  \App\Events\CommercialReportaged  $event
     * @return void
     */
    public function handle(CommercialReportaged $event)
    {
        $commercial = $event->commercial;
        $message = 'بانک آگهی
آگهی شما با موفقیت رپورتاژ گردید.
با تشکر
';
        Sms::send($message, $commercial->user->mobile);
    }
}
