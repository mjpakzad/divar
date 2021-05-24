<?php

namespace App\Providers;

use App\Events\CommercialExpired;
use App\Events\CommercialPromoted;
use App\Events\CommercialPublished;
use App\Events\CommercialRejected;
use App\Events\CommercialReportaged;
use App\Listeners\SendExpiredCommercial;
use App\Listeners\SendGreeting;
use App\Listeners\SendMobileVerificationCode;
use App\Listeners\SendPromotedCommercial;
use App\Listeners\SendPublishedCommercial;
use App\Listeners\SendRejectedCommercial;
use App\Listeners\SendReportagedCommercial;
use App\Listeners\SetTwoFactorUnverified;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\SetDefaultRole;
use App\Listeners\SetDefaultTwoFactor;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;
use App\Events\VerificationCodeRequested;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            //SendEmailVerificationNotification::class,
            SetDefaultRole::class,
            SetDefaultTwoFactor::class,
            SendGreeting::class,
        ],
        Login::class => [
            LogSuccessfulLogin::class,
            SetTwoFactorUnverified::class,
        ],
        VerificationCodeRequested::class => [
            SendMobileVerificationCode::class,
        ],
        CommercialPublished::class => [
            SendPublishedCommercial::class,
        ],
        CommercialExpired::class => [
            SendExpiredCommercial::class,
        ],
        CommercialPromoted::class => [
            SendPromotedCommercial::class,
        ],
        CommercialRejected::class => [
            SendRejectedCommercial::class,
        ],
        CommercialReportaged::class => [
            SendReportagedCommercial::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
