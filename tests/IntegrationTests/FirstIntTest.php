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

use tantrum_elastic\tests\IntegrationTests\IntegrationTestCase;
use tantrum_elastic\Tantrum as T;
use tantrum_elastic\Factory\Search\QueryFactory as QF;

class FirstIntTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function firstTest()
    {
        $documents = T::init()->searchBool('tantrum_elastic_test_data_search')
            ->must(QF::Term('vehicle_type', 'Taxi'))
            ->fetch(0, 10);
    }
}
