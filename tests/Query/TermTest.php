<?php

namespace tantrum_elastic\tests\Query;

use tantrum_elastic\Query\Term;
use tantrum_elastic\tests\TestCase;

class TermTest extends TestCase
{

    /**
     * @test
     */
    public function setVauesSucceeds()
    {
        $field = self::uniqid();
        $value = self::uniqid();

        $term = new Term();
        $term->setField($field);
        $term->setValue($value);

        $expected = ['term' => [$field => $value]];

        self::assertEquals(json_encode($expected), self::containerise($term));
    }
}
