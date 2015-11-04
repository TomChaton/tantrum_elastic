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

namespace tantrum_elastic;

use GuzzleHttp\Psr7\Request;
use Pimple\Container;
use Psr\Log\AbstractLogger;
use Psr\Log\NullLogger;
use Psr\Http\Message\RequestInterface;
use tantrum_elastic\Factory\Search\Base;
use tantrum_elastic\Factory\Search\Bool;
use tantrum_elastic\Lib\RequestProvider;
use GuzzleHttp\Client;

/**
 * This class is the interface for the client library.
 * It allows the developer to:
 *  - Set a psr7 request object pre-provisioned with host and port.
 *  - Set a psr3 logger object
 *  - Set an http client which will accept a psr7 StreamInterface object (useful for testing
 * It gives access to factory methods and classes which aim to simplify your interactions with elasticsearch
 * @package tantrum_elastic
 */
class Tantrum
{
    /** @var Container $container */
    protected $container;

    // Initialisation

    /**
     * Provision the container, logger and request
     * Accepts a PSR3 compliant logger object and/or PSR7 httpClient object
     * @param AbstractLogger   $logger      - a PSR3 compliant log object
     * @param RequestInterface $httpRequest - a PSR7 compliant request object
     */
    public function __construct($logger = null, $httpRequest = null)
    {
        $this->container = new Container();
        $this->setLogger($this->initLogger($logger));
        $this->setHttpRequest($this->initHttpRequest($httpRequest));
        $this->setClient(new Client());
    }

    /**
     * Static convenience method for initialisation
     * Accepts a PSR3 compliant logger object and/or PSR7 httpClient object
     * @param AbstractLogger   $logger      - a PSR3 compliant log object
     * @param RequestInterface $httpRequest - a PSR7 compliant request object
     * @return Tantrum
     */
    public static function init($logger = null, $httpRequest = null)
    {
        $tantrum = new Tantrum($logger, $httpRequest);
        return $tantrum;
    }

    /**
     * Set an instance of AbstractLogger in the container
     * @param AbstractLogger $logger
     */
    public function setLogger(AbstractLogger $logger)
    {
        // @todo: Create a provider for this?
        $this->container['logger'] = $logger;
        return $this;
    }

    /**
     * Set an instance of RequestInterface in the container
     * @param RequestInterface $request
     */
    public function setHttpRequest(RequestInterface $request)
    {
        $request = $request->withHeader('Accept', 'application/json');
        $this->requestProvider = new RequestProvider($request);
        $this->container->register($this->requestProvider);
        return $this;
    }


    /**
     * @param Client $client
     * @return $this
     */
    public function setClient(Client $client)
    {
        $this->container['client'] = $client;
        return $this;
    }

    // Search Methods

    /**
     * Return a Filtered search factory
     * @param $index
     * @param null $type
     * @return Bool
     */
    public function searchBool($index, $type = null)
    {
        return $this->getSearchFactory('Bool', $index, $type);
    }


    // Private methods

    /**
     * Intitialise a logger instance
     * @param null $logger
     * @return null|NullLogger
     */
    private function initLogger($logger = null)
    {
        if(!is_null($logger)) {
            return $logger;
        } else {
            return new NullLogger();
        }
    }

    /**
     * Initialise a Request instance
     * @param null $request
     * @return Request
     */
    private function initHttpRequest($request = null)
    {
        if(is_null($request)) {
            $request = new Request(null, 'http://localhost:9200');
        }
        return $request;
    }

    /**
     * Create and return a specialized search factory
     * @param $factory
     * @param $index
     * @param null $type
     * @return Base
     */
    private function getSearchFactory($factory, $index, $type = null)
    {
        $this->container['requestProvider']->setRequestPath($index, '_search', $type);
        $this->container['requestProvider']->setRequestMethod('GET');

        $this->container['sortCollection'] = function ($c) {
            return new \tantrum_elastic\Sort\Collection();
        };
        return $this->getFactory('Search', $factory);
    }

    /**
     * Get a factory
     * @param $namespace
     * @param $factory
     * @return mixed
     */
    private function getFactory($namespace, $factory)
    {
        $factoryName = sprintf('tantrum_elastic\Factory\%s\%s', $namespace, $factory);
        return new $factoryName($this->container);
    }
}
