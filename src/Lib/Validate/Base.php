<?php

namespace tantrum_elastic\Lib\Validate;

use tantrum_elastic\Exception;

trait Base
{
    /**
     * Throws the default exception with the provided message
     * @param  string $message
     * @param  string exceptionClass
     * @throws tantrum_elastic\Exception\General
     * @return void
     */
    public static function handleValidationError($message, $exceptionClass = 'General')
    {
        $namespace = 'tantrum_elastic\Exception';
        throw new $namespace.$exceptionClass($message);
    }
}
