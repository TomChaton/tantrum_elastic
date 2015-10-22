<?php

namespace tantrum_elastic\Query;

use tantrum_elastic\Lib\Fragment;
use tantrum_elastic\Lib\Validate;

/**
 * This class is responsible for provisioning and rendering the multi_match query object
 * @package tantrum_elastic\Query
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-multi-match-query.html
 */
class MultiMatch extends Base
{
    use Fragment\SingleValue;

    use Lib\MinimumShouldMatchTrait;

    use Validate\Strings;
    use Validate\Arrays;
    use Validate\Floats;
    use Validate\Integers;

    const TYPE_BEST_FIELDS   = 'best_fields';
    const TYPE_CROSS_FIELDS  = 'cross_fields';
    const TYPE_MOST_FIELDS   = 'most_fields';
    const TYPE_PHRASE        = 'phrase';
    const TYPE_PHRASE_PREFIX = 'best_fields';

    /**
     * @var array
     */
    public static $allowedTypes = [
        self::TYPE_BEST_FIELDS,
        self::TYPE_CROSS_FIELDS,
        self::TYPE_MOST_FIELDS,
        self::TYPE_PHRASE,
        self::TYPE_PHRASE_PREFIX,
    ];

    const OPERATOR_AND       = 'and';
    const OPERATOR_OR        = 'or';

    /**
     * @var array
     */
    public static $allowedOperators = [
        self::OPERATOR_AND,
        self::OPERATOR_OR,
    ];

    /**
     * Set the type of multimatch query
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->validateValueExistsInArray($type, self::$allowedTypes, sprintf('Type must be one of "%s"', implode('|', self::$allowedTypes)), 'NotSupported');
        $this->addOption('type', $type);
        return $this;
    }

    /**
     * Set the tiebreaker
     * @param $tieBreaker
     * @return $this
     */
    public function setTieBreaker($tieBreaker)
    {
        $this->validateFloat($tieBreaker);
        $this->addOption('tie_breaker', $tieBreaker);
        return $this;
    }

    /**
     * Add a field
     * @param mixed $field
     * @return $this
     */
    public function addField($field)
    {
        $this->validateString($field);
        if(!array_key_exists('fields', $this->options)) {
            $this->options['fields'] = [];
        }
        $this->options['fields'][] = $field;

        return $this;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->validateString($value);
        $this->options['query'] = $value;

        return $this;
    }

    /**
     * Set the operator
     * @param $operator
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->validateValueExistsInArray($operator, self::$allowedOperators, sprintf('Operator must be one of "%s"', implode('|', self::$allowedOperators)), 'NotSupported');
        $this->addOption('operator', $operator);
        return $this;
    }
}
