<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public function render($request)
    {
        return [
            'message' => $this->getMessage(),
            'errors' => $this->getMessage(),
        ];
    }
}
