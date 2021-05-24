<?php

namespace App\Listeners;

use App\Events\VerificationCodeRequested;
use Illuminate\Http\Request;
use App\Models\TwoFactor;
use Sms;

class SendMobileVerificationCode
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
     * @param  \App\Events\VerificationCodeRequested  $event
     * @return void
     */
    public function handle(VerificationCodeRequested $event)
    {
        $user = $event->user;

        $twoFactor = new TwoFactor([
            'code'      => TwoFactor::generateCode(),
            'user_id'   => $user->id,
        ]);
        $twoFactor->save();

        $user->two_factor_verified_at = null;
        $user->save();
        $message = 'کد تایید شما در کشتی داران: ' . $twoFactor->code;
        send_sms($user->mobile, $message);
        //Sms::sendVerification($twoFactor->code, $user->mobile);
    }
}
