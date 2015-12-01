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

namespace tantrum_elastic\Transport;

use tantrum_elastic\Payload;
use tantrum_elastic\Response;
use tantrum_elastic\Lib\Validate;
use tantrum_elastic\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\RequestInterface;

/**
 * This class is responsible for making the query to the elasticsearch cluster
 * @package tantrum_elastic\Transport
 */
class Http
{
    use Validate\Strings;
    use Validate\Integers;

    /**
     * The query we will send
     * @var Payload\Base
     */
    private $payload;

    /**
     * A RequestInterface object, populated with host, port and path
     * @var RequestInterface
     */
    private $request;

    /**
     * A guzzle Client object
     * @var Client
     */
    private $client;

    /**
     * Set the payload object that will form the request body
     *
     * @param Payload\Base $payload
     *
     * @return $this
     */
    public function setPayload(Payload\Base $payload)
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Set the RequestInterface object
     * @param RequestInterface $request
     * @return $this
     */
    public function setHttpRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Get the http request
     * @return Request
     */
    private function getHttpRequest()
    {
        if (is_null($this->request)) {
            throw new \RuntimeException('No Psr\Http\Request object set.');
        }

        return $this->request;
    }

    /**
     * Set the http client
     * @param Client $client
     *
     * @return $this
     */
    public function setHttpClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get the http client, or create and return a new one
     *
     * @return Client
     */
    private function getHttpClient()
    {
        // @codeCoverageIgnoreStart
        if (is_null($this->client)) {
            $this->client = new Client();
        }
        // @codeCoverageIgnoreEnd

        return $this->client;
    }

    /**
     * Build and send the request
     *
     * @throws Exception\Transport\Client
     * @throws Exception\Transport\Server
     *
     * @return Response\Base
     */
    public function send()
    {
        $request = $this->getHttpRequest();

        try {
            $client = $this->getHttpClient();
            $request = $request->withBody($this->payload);
            $response = $client->send($request);
        } catch (ClientException $ex) {
            throw new Exception\Transport\Client($ex->getResponse()->getBody(), $ex->getCode(), $ex);
        } catch (ServerException $ex) {
            throw new Exception\Transport\Server($ex->getResponse()->getBody(), $ex->getCode(), $ex);
        }

        // The error suppression here is because elastic search returns -9223372036854775808
        // when an attempt to sort on a missing field is made.
        // This happens to be 1 larger than the maximum integer on a 64 bit system
        // This is probably not a coincidence, but I won't dwell on that right now.
        // Suffice it to say that the value comes though in the decoded json, but php screams about it
        $responseBuilder = new Response\Builder($this->payload, @json_decode($response->getBody(), true, 512, JSON_BIGINT_AS_STRING));
        return $responseBuilder->getResponse();
    }
}
