<?php

namespace tantrum_elastic\Sort;

use tantrum_elastic\Lib;
use tantrum_elastic\Lib\Validate;

abstract class Base extends Lib\Element
{
    use Lib\Fragment\SingleField;
    use Lib\Validate\Arrays;
    use Lib\Validate\Strings;

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

    public function setOrder($order)
    {
        $this->validateString($order, 'Order must be a string');
        $this->validateStringIsInArray($order, self::$allowedSortOrders, sprintf('Order must be one of "%s"', implode('|', self::$allowedSortOrders)));
        $this->addOption('order', $order);
        return $this;
    }

    public function setMode($mode)
    {
        $this->validateString($mode, 'Mode must be a string');
        $this->validateStringIsInArray($mode, self::$allowedModes, sprintf('Mode must be one of "%s"', implode('|', self::$allowedModes)));
        $this->addOption('mode', $mode);
        return $this;
    }

    public function jsonSerialize()
    {
        return $this->process($this->field);
    }
}
