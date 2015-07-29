<?php

namespace tantrum_elastic\Response;

use tantrum_elastic\Request as RequestBody;
use tantrum_elastic\Exception;

class Builder
{
    /**
     * @var tantrum_elastic\Response
     */
    private $responseObject;

    /**
     * @param Request\Base $request     - The request object from which the payload was created
     * @param array        $response    - The decoded response body 
     */
    final public function __construct(RequestBody\Base $request, array $response)
    {
        $requestType = $request->getType();
        $this->responseObject = $this->getResponseByType($requestType);
        $this->initialiseResponse($response);
    }

    /**
     * Return the appropriate response object for the request type
     * @param  string $type
     * @throws tantrum_elastic\Exception\NotSupported
     * @return tantrum_elastic\Response\Base
     */
    private function getResponseByType($type)
    {
        switch($type) {
            case RequestBody\Base::TYPE_SEARCH:
                return new Search();
            default:
                throw new Exception\NotSupported(sprintf('Response type "%s" is not supported', $type));
        }

    }

    /**
     * Set the response array in the response object
     * @param  array $response
     * @return void
     */
    private function initialiseResponse(array $response)
    {
        $this->responseObject->setResponseArray($response);
    }

    /**
     * Return the response object
     * @return tantrum_elastic\Response\Base
     */
    final public function getResponse()
    {
        return $this->responseObject;
    }
}
