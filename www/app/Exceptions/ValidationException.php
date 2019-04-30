<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 15:01
 */

namespace App\Exceptions;

class ValidationException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 405);
    }
}