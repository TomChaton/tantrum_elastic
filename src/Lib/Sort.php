<?php

namespace tantrum_elastic\Lib;

class Sort extends Descriptor
{
    use Validate\Strings;

    const ORDER_ASC = 'asc';
    const ORDER_DESC = 'desc';

    /**
     * Array of allowed values
     * @var array
     */
    private static $allowedSortOrders = array(
        self::ORDER_ASC,
        self::ORDER_DESC,
    );
    
    /**
     * Set the field target for the sort object
     * @param string] $target
     */
    public function addTarget($target)
    {
        $this->validateString($target);
        $this->targets[] = $target;
    }

    /**
     * @throws tantrum_elastic\Exception\NotSupported
     * @param array $targets
     */
    public function setTargets(array $targets)
    {
        throw new Exception\NotSupported('You cannot set multiple targets for a Sort object');
    }

    /**
     * Set the sort order value (asc / desc) for the sort object
     * @param string $value
     */
    public function addValue($value)
    {
        $this->validateStringIsInArray($value, self::$allowedSortOrders);
        $this->values[] = $value;
    }

    /**
     * @throws tantrum_elastic\Exception\NotSupported
     * @param array $values
     */
    public function setValues(array $values)
    {
        throw new Exception\NotSupported('You cannot set multiple values for a Sort object');
    }

    /**
     * Return the array representation of this object
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            $this->targets[0] => [
                'order' => $this->values[0],
            ],
        ];
    }
}
