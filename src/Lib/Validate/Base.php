<?php

namespace tantrum_elastic\Lib\Validate;

/**
 * Base validation trait. This trait is called statically by other validation traits to provide common
 * functionality not available through trait inheritance
 * @package tantrum_elastic\Lib\Validate
 */
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
