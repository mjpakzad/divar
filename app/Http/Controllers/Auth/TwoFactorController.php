<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\VerificationTwoFactorRequest;
use App\Models\TwoFactor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\VerificationCodeRequested;

class TwoFactorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('twoFactorVerified');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerificationCode()
    {
        $user = auth()->user();
        event(new VerificationCodeRequested($user));
        $this->doneMessage('کد تایید به شماره موبایل شما ارسال گردید.');
        return redirect()->route('twoFactor.verificationForm');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showVerificationForm()
    {
        return view('auth.verification');
    }

    /**
     * @param VerificationTwoFactorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verification(VerificationTwoFactorRequest $request)
    {
        $user = auth()->user();
        $user->two_factor_verified_at = now();
        if (is_null($user->mobile_verified_at))
        {
            $user->mobile_verified_at = now();
        }
        $user->save();
        $twoFactor = TwoFactor::find($user->twoFactorCode()->id);
        $twoFactor->used = true;
        $twoFactor->save();
        $this->doneMessage('کد تایید با موفقیت تایید گردید.');
        return redirect()->route('frontend.app.index');
    }
}