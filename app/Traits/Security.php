<?php

namespace App\Traits;

trait Security
{
    public static function generateCode(int $codeLength = 5)
    {
        $min = pow(10, $codeLength-1);
        $max = $min * 10 - 1;
        return mt_rand($min, $max);
    }

    public function isValid()
    {
        return !$this->isUsed() && !$this->isExpired();
    }

    public function isUsed()
    {
        return $this->used;
    }

    public function isExpired()
    {
        return $this->created_at->diffInMinutes(now()) > static::EXPIRATION_TIME;
    }
}