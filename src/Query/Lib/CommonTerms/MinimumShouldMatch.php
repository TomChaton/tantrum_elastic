<?php
/**
 * This file is part of tantrum_elastic.
 *
 *  tantrum_elastic is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  tantrum_elastic is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with tatrum_elastic.  If not, see <http://www.gnu.org/licenses/>.
 */

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
