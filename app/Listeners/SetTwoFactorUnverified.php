<?php

namespace App\Listeners;

use App\Events\VerificationCodeRequested;
use Carbon\Carbon;
use Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetTwoFactorUnverified
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
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->two_factor_verified_at = null;
        $user->save();

        if ($user->two_factor_activated)
        {
            Event::fire(new VerificationCodeRequested($user));
        }
    }
}
