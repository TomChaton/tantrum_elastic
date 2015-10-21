<?php

namespace tantrum_elastic\Query\Lib\CommonTerms;

use tantrum_elastic\Lib\Element;
use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Query\Lib\MinimumShouldMatchFrequency as MinimumShouldMatchFrequencyTrait;

class MinimumShouldMatch extends Element
{
    use Validate\Integers;
    use MinimumShouldMatchFrequencyTrait;
}
