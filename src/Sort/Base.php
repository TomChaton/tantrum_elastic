<?php

namespace tantrum_elastic\Sort;

use tantrum_elastic\Lib\Element;
use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Lib\Fragment;

abstract class Base extends Element
{
    use Fragment\SingleField;

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
     * Set the sort order
     *
     * @param string $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->validateString($order, 'Order must be a string', 'Sort\InvalidSortOrder');
        $this->validateValueExistsInArray($order, self::$allowedSortOrders, sprintf('Order must be one of "%s"', implode('|', self::$allowedSortOrders)), 'Sort\InvalidSortOrder');
        $this->addOption('order', $order);
        return $this;
    }

    /**
     * Set the sort mode
     *
     * @param string $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->validateString($mode, 'Mode must be a string', 'Sort\InvalidSortMode');
        $this->validateValueExistsInArray($mode, self::$allowedModes, sprintf('Mode must be one of "%s"', implode('|', self::$allowedModes)), 'Sort\InvalidSortMode');
        $this->addOption('mode', $mode);
        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    public function getElementName()
    {
        return $this->field;
    }
}
