<?php

namespace App\Exceptions;


final class MissingFieldException extends \Exception
{
    /**
     * MissingFieldException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}
