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

use Pimple\ServiceProviderInterface;
use GuzzleHttp\Psr7\Request;
use Pimple\Container as DiContainer;

class RequestProvider implements ServiceProviderInterface
{
    const KEY = 'request';

    /** @var Request $request */
    private $request;

    /** @var DiContainer $container */
    private $container;

    /**
     * Provision the request object
     * @param Request $request
     */
    final public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Set the HTTP method on the request
     * @param $method
     */
    public function setRequestMethod($method)
    {
        $request = $this->getRequest();
        $request = $request->withMethod($method);
        $this->setRequest($request);
    }

    /**
     * Set the request path on the request instance
     * @param $index
     * @param $action
     * @param null $type
     */
    public function setRequestPath($index, $action, $type = null)
    {
        $path = str_replace('//', '/', sprintf('/%s/%s/%s', $index, $type, $action));

        $request = $this->getRequest();

        $uri = $request->getUri();
        $uri = $uri->withPath($path);
        $request = $request->withUri($uri);

        $this->setRequest($request);
    }

    /**
     * Get the request instance from the container
     * @internal
     * @return Request
     */
    private function getRequest()
    {
        return $this->container->raw(self::KEY);
    }

    /**
     * Set the request in the container
     * @param Request $request
     */
    private function setRequest($request)
    {
        $this->container->offsetSet(self::KEY, $request);
    }

    /**
     * Register the provider with the container
     * @param DiContainer $container
     */
    public function register(DiContainer $container)
    {
        $this->container = $container;
        $this->container[self::KEY] = $this->request;
        $this->container['requestProvider'] = $this;
    }
}
