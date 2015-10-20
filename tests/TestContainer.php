<?php

namespace tantrum_elastic\tests;

use tantrum_elastic\Lib\Element;

class TestContainer extends Element
{
    /**
     * @var Element
     */
    private $testSubject;

    public function __construct(Element $testSubject)
    {
        $this->testSubject = $testSubject;
        $this->addElement($testSubject);
    }

    public function __call($method, $args)
    {
        if (!method_exists($this->testSubject, $method)) {
            throw new \Exception("unknown method [$method]");
        }

        return call_user_func_array(
            array($this->testSubject, $method),
            $args
        );
    }

    public function __get($key)
    {
        return $this->testSubject->$key;
    }

    public function getElement()
    {
        return $this->testSubject;
    }
}