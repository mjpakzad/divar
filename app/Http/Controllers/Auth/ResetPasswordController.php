<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\ResetPasswordRequest;
use App\Traits\ResetPassword;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    use ResetPassword;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  int  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm($token = null)
    {
        return view('auth.passwords.reset', compact('token'));
    }

    /**
     * Reset the given user's password.
     *
     * @param  ResetPasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $passwordReset = PasswordReset::mobile($request->mobile)->token($request->token)->latest()->first();
        $errors = new MessageBag();
        if (!$passwordReset) {
            $errors->add('wrong', 'کد ارسالی یا شماره موبایل اشتباه است!');
        }
        if (!$passwordReset->isValid()) {
            $errors->add('invalid', 'کد ارسالی معتبر نیست!');
        }
        if ($errors->isNotEmpty()) {
            return redirect()
                ->back()
                ->withErrors($errors)
                ->withInput();
        }
        $user = User::whereMobile($request->mobile)->firstOrFail();
        $passwordReset->used = true;
        $passwordReset->save();
        $this->resetPassword($user, $request->password);
        $this->doneMessage('پسورد شما با موفقیت تغییر یافت.');
        return redirect()->route('frontend.app.index');
    }
}
