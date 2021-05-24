<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Shows a message with short lifetime.
     * @param string $msg
     * @param string status
     * @param string $title
     */
    public function doneMessage($msg = 'با موفقیت انجام شد', $status = 'success', $title = '')
    {
        return session()->flash('msg', ['status' => $status, 'title' => $title,'message' => $msg]);
    }
}
