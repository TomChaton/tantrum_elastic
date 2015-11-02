<?php

namespace tantrum_elastic\Transport;

use tantrum_elastic\Lib\Validate;

/**
 * This class builds a query string for the transport object
 * @package tantrum_elastic\Transport
 */
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

    /**
     * @var array
     */
    private static $keys = [
        self::KEY_HOST_NAME,
        self::KEY_PORT,
        self::KEY_INDICES,
        self::KEY_DOCUMENT_TYPES,
        self::KEY_ACTION,
        self::KEY_QUERY,
    ];

    /**
     * @var array
     */
    private $values = [
        self::KEY_HOST_NAME => 'http://localhost',
        self::KEY_PORT      => 9200,
    ];

    /**
     * Make sure nothing can extend this class
     */
    final public function __construct()
    {
    }

    /**
     * Set the host name
     *
     * @param string $hostName
     */
    public function setHostName($hostName)
    {
        $this->validateString($hostName, 'Host name must be a string');
        $this->values[self::KEY_HOST_NAME] = $hostName;
    }

    /**
     * Add the port number
     *
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->validateIntegerRange($port, 1, 65535, 'Port is not within valid range 1-65535', 'Transport\InvalidPort');
        $this->values[self::KEY_PORT] = $port;
    }

    /**
     * The action we will perform
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->validateString($action, 'Action must be a string');
        $this->values[self::KEY_ACTION] = $action;
    }

    /**
     * Add a document type
     *
     * @param string $documentType
     */
    public function addDocumentType($documentType)
    {
        $this->validateString($documentType, 'Document type must be a string');
        $this->values[self::KEY_DOCUMENT_TYPES][] = $documentType;
    }

    /**
     * Add an index name/alias
     *
     * @param string $index
     */
    public function addIndex($index)
    {
        $this->validateString($index, 'Index must be a string');
        $this->values[self::KEY_INDICES][] = $index;
    }

    /**
     * Add a query string key/value pair
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function addQuery($key, $value)
    {
        $this->values[self::KEY_QUERY][$key] = $value;
    }

    /**
     * Return the completed url
     *
     * @return string
     */
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
