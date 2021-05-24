<?php

namespace App\Traits;

use App\Models\PasswordReset;
use Sms;

trait ResetPassword
{
    /**
     * Create a new password reset token for the given user,
     * That token will be send to the user with the link to reset password.
     * A new record will be saved in password_resets table.
     *
     * @param  int  $mobile the user mobile number
     * @return PasswordReset
     */
    protected function createToken($mobile)
    {
        $passwordReset = new PasswordReset([
            'mobile'    => $mobile,
            'token'     => PasswordReset::generateCode(),
        ]);
        $passwordReset->save();
        return $passwordReset;
    }

    /**
     * Delete password reset tokens of the given user,
     * The record which was created in the password_resets table will also be deleted.
     *
     * @param  int  $mobile
     * @param  int  $token
     * @return mixed
     */
    protected function deleteToken($mobile, $token)
    {
        return $this->findToken($mobile, $token)->delete();
    }

    /**
     * @param  int  $mobile
     * @param  int  $token
     * @return mixed
     */
    protected function findToken($mobile, $token)
    {
        return ResetPassword::whereMobile($mobile)->whereToken($token)->first();
    }

    /**
     * Validate the given password reset token,
     * This function will check if the token passed in the argument exists for that given user.
     *
     * @param $mobile
     * @param $token
     * @return bool determine whether a matched record found or not?
     */
    protected function tokenExists($mobile, $token) : bool
    {
        return !!$this->findToken($mobile, $token);
    }

    /**
     * Send a password reset link to a user.
     * This function will create token and send an email with the password reset link to the user.
     *
     * @param  int  $mobile
     * @param  int  $token
     */
    protected function sendResetLink($mobile, $token)
    {
        $message = 'با سلام
        کد تایید شماره موبایل شما در بانک آگهی: ' . $token . ' لینک ورود کد:
        ' . route('password.reset', $token);

        Sms::send($message, $mobile);
    }
}
