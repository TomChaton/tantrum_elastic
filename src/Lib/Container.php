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

namespace tantrum_elastic\Lib;
use Interop\Container\ContainerInterface;
use tantrum_elastic\Exception\NotFoundException;

/**
 * This is the dependency injection container for tantrum_elastic
 * It provides instantiation of objects as well at the ability to access objects by key
 * @package tantrum_elastic\Lib
 */
class Container implements ContainerInterface
{
    /** @var array */
    protected $providers = [];

    /**
     * Initialise the container with all the providers we're likely to need.
     * @return void
     */
    public function addProvider($namespace, callable $provider)
    {
        $this->providers[$namespace] = $provider;
    }

    /**
     * Factory method for creating elements
     * @param string $namespace - The namespace of the object to create
     * @throws NotFoundException
     * @return mixed ;
     */
    public function get($namespace)
    {
        if(!array_key_exists($namespace, $this->providers)) {
            throw new NotFoundException(sprintf('Cannot make element; No provider for "%s".', $namespace));
        }

        $this->elements[$namespace] = $this->providers[$namespace]();
        return $this->elements[$namespace];
    }

    public function has($namespace)
    {
        return array_key_exists($namespace, $this->providers);
    }
}
