<?php

namespace tantrum_elastic\Transport;

use tantrum_elastic\Lib\Validate;

class RequestString
{
    use Validate\Strings;
    use Validate\Integers;
    use Validate\Arrays;

    const KEY_HOST_NAME      = 'host';
    const KEY_PORT           = 'port';
    const KEY_INDICES        = 'indices';
    const KEY_DOCUMENT_TYPES = 'types';
    const KEY_ACTION         = 'action';
    const KEY_QUERY          = 'query';

    private static $keys = [
        self::KEY_HOST_NAME,
        self::KEY_PORT,
        self::KEY_INDICES,
        self::KEY_DOCUMENT_TYPES,
        self::KEY_ACTION,
        self::KEY_QUERY,
    ];

    private $values = [
        self::KEY_HOST_NAME => 'http://localhost',
        self::KEY_PORT      => 9200,
    ];

    final public function __construct()
    {
    }
    
    public function setHostName($hostName)
    {
        $this->validateString($hostName, 'Host name must be a string');
        $this->values[self::KEY_HOST_NAME] = $hostName;
    }

    public function setPort($port)
    {
        $this->validateIntegerRange($port, 1, 65535, 'Port is not within valid range 1-65535', 'Transport\InvalidPort');
        $this->values[self::KEY_PORT] = $port;
    }

    public function setAction($action)
    {
        $this->validateString($action, 'Action must be a string');
        $this->values[self::KEY_ACTION] = $action;
    }

    public function addDocumentType($documentType)
    {
        $this->validateString($documentType, 'Document type must be a string');
        $this->values[self::KEY_DOCUMENT_TYPES][] = $documentType;
    }

    public function addIndex($index)
    {
        $this->validateString($index, 'Index must be a string');
        $this->values[self::KEY_INDICES][] = $index;
    }

    public function addQuery($key, $value)
    {
        $this->values[self::KEY_QUERY][$key] = $value;
    }

    public function format()
    {
        $parts = [];
        foreach ($this->values as $key => $value) {
            $position = array_search($key, self::$keys, true);

            switch($key) {
                case self::KEY_HOST_NAME:
                    $parts[$position] = sprintf('%s:%d', $value, $this->values[self::KEY_PORT]);
                    break;
                case self::KEY_ACTION:
                    $parts[$position] = $value;
                    break;
                case self::KEY_INDICES:
                case self::KEY_DOCUMENT_TYPES:
                    if (count($value) === 1) {
                        $parts[$position] = $value[0];
                    } else {
                        $parts[$position] = implode(',', $value);
                    }
                    break;
                case self::KEY_QUERY:
                    $parts[$position] = sprintf('?%s', http_build_query($value));
                    break;
            }
        }

        return implode('/', $parts);
    }
}
