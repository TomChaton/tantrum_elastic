<?php

namespace tantrum_elastic\Query\Lib\CommonTerms;

use tantrum_elastic\Lib\Element;
use tantrum_elastic\Lib\Validate;

/**
 * This class implements the MinimumShouldMatchFrequency trait, giving the common terms query its extended
 * minimum_should_match functionality.
 * @package tantrum_elastic\Query\Lib\CommonTerms
 */
class MinimumShouldMatch extends Element
{
    use Validate\Integers;
    use MinimumShouldMatchFrequencyTrait;
}
