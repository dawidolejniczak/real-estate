<?php


namespace App\Exceptions;


final class ValidationException extends \Exception
{
    /**
     * ValidationException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 406);
    }
}
