<?php

namespace tantrum_elastic\Lib\Validate;

use tantrum_elastic\Lib\Exception;

trait Base
{
    /**
     * Throws the default exception with the provided message
     * @param  string $message
     * @param  string exceptionClass
     * @throws \Exception
     * @return void
     */
    public static function handleValidationError($message, $exceptionClass = 'General')
    {
        $namespace = 'tantrum_elastic\Lib\Exception';
        throw new $namespace.$exceptionClass($message);
    }
}