<?php

namespace App\Exceptions;
 use Illuminate\Http\Exceptions\PostTooLargeException;

use Exception;
use Throwable;

class Handler extends Exception
{
   

public function render($request, Throwable $exception)
{
    if ($exception instanceof PostTooLargeException) {
        return redirect()->back()->withErrors([
            'Your upload is too large. Maximum allowed size is 8MB.'
        ]);
    }

}
}
