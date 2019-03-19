<?php

namespace App\Exceptions;


final class ModelDoesNotExistException extends \Exception
{
    /**
     * ModelDoesNotExistException constructor.
     */
    public function __construct()
    {
        parent::__construct('Models does not exist.', 400);
    }
}
