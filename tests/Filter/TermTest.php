<?php

namespace tantrum_elastic\tests\Filter;

use tantrum_elastic\tests\TestCase;
use tantrum_elastic\Filter\Term;

class TermTest extends TestCase
{
    /**
     * @var Term
     */
    protected $element;

    /**
     * @test
     */
    public function jsonSerializeSucceeds()
    {
        $field = self::uniqid();
        $value = self::uniqid();

        $this->element->setField($field);
        $this->element->setValue($value);

        $expected = $this->getExpected();
        $expected['term'] = [$field => $value];
        self::assertEquals(json_encode($expected), self::containerise($this->element));
    }

    // Utils

    public function setUp()
    {
        $this->element = new Term();
    }

    protected function getExpected()
    {
        return [
            'term' => [],
        ];
    }
}
