<?php

namespace tantrum_elastic\Lib\Validate;

trait Base
{
    /**
     * Builds the class namespace for an exception
     * Returns the namespace for the base Validation class on null
     *
     * @param  string $exceptionClass
     *
     * @return string
     */
    public static function buildExceptionNamespace($exceptionClass = 'Validation')
    {
        return 'tantrum_elastic\Exception\\'.$exceptionClass;
    }
}
