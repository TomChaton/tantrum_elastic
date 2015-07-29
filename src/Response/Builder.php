<?php

namespace tantrum_elastic\Response;

use tantrum_elastic\Request;
use tantrum_elastic\Exception;

class Builder
{
    /** @var tantrum_elastic\Response */
    private $responseObject;

    /**
     * @param Request\Base $request     - The request object from which the payload was created
     * @param array        $response    - The decoded response body 
     */
    final public function __construct(Request\Base $request, array $response)
    {
        $responseObject = $this->getResponseFromRequest($request);
        $this->initialiseResponse($responseObject, $response);
    }

    /**
     * Return the appropriate response object for the request type
     * @param  string $type
     * @throws tantrum_elastic\Exception\NotSupported
     * @return tantrum_elastic\Response\Base
     */
    private function getResponseFromRequest(Request\Base $request)
    {
        $type = $request->getType();
        switch($type) {
            case Request\Base::TYPE_SEARCH:
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
    private function initialiseResponse(Base $responseObject, array $response)
    {
        $responseObject->setResponseArray($response);
        $this->responseObject = $responseObject;
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
