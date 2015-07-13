<?php

namespace tantrum_elastic\Sort;

use tantrum_elastic\Lib;
use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Exception;

abstract class Base extends Lib\Descriptor
{
    use Validate\Arrays;
    use Validate\Strings;

    const ORDER_ASC  = 'asc';
    const ORDER_DESC = 'desc';

    const MODE_AVG   = 'avg';
    const MODE_MAX   = 'max';
    const MODE_MIN   = 'min';
    const MODE_SUM   = 'sum';

    /**
     * Array of allowed sort orders
     * @var array
     */
    private static $allowedSortOrders = array(
        self::ORDER_ASC,
        self::ORDER_DESC,
    );

    /**
     * Array of allowed modes
     * @var array
     */
    private static $allowedModes = [
        self::MODE_AVG,
        self::MODE_MAX,
        self::MODE_MIN,
        self::MODE_SUM,
    ];

    /**
     * Array of common options for Sort objects
     * @var array
     */
    protected $options = [];

    protected function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    final public function setValues(array $values)
    {
        throw new Exception\NotSupported('Sort objects do not accept values.');
    }

    final public function addValue($value)
    {
        throw new Exception\NotSupported('Sort objects do not accept values.');
    }

    final public function setTargets(array $targets)
    {
        foreach ($targets as $target) {
            $this->addTarget($target);
        }

        return $this;
    }

    final public function addTarget($target)
    {
        $this->validateArrayMaximumCount($this->targets, 0, 'A maximum of 1 target is allowed in sort objects', 'InvalidTarget');
        $this->targets[] = $target;
        return $this;
    }

    public function setOrder($order)
    {
        $this->validateString($order, 'Order must be a string');
        $this->validateStringIsInArray($order, self::$allowedSortOrders, sprintf('Order must be one of "%s"', implode('|', self::$allowedSortOrders)));
        $this->setOption('order', $order);
        return $this;
    }

    public function setMode($mode)
    {
        $this->validateString($mode, 'Mode must be a string');
        $this->validateStringIsInArray($mode, self::$allowedModes, sprintf('Mode must be one of "%s"', implode('|', self::$allowedModes)));
        $this->setOption('mode', $mode);
        return $this;
    }

    public function jsonSerialize()
    {
        $this->validateArrayMinimumCount($this->targets, 1, 'No Target set on Sort object', 'InvalidTarget');

        if (empty($this->options)) {
            return $this->targets[0];
        } else {
            return [$this->targets[0] => $this->options];
        }
    }
}
