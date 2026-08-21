<?php
namespace App\Exceptions;
class CurlException extends \Exception
{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
