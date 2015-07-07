<?php

namespace tantrum_elastic\Lib\Validate;

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
        $classPath = 'tantrum_elastic\Exception\\'.$exceptionClass;
        throw new $classPath($message);
    }
}
