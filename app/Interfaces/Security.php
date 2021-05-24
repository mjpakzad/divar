<?php
namespace App\Interfaces;

interface Security
{
    const EXPIRATION_TIME = 15; // minutes

    public static function generateCode(int $codeLength = 5);
}