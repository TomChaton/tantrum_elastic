<?php

namespace tantrum_elastic\Response;

use tantrum_elastic\Request;
use tantrum_elastic\Exception;

class Builder
{
    /** @var Base */
    private $responseObject;

    /**
     * Create and initialise a response object
     *
     * @param Request\Base $request - The request object from which the payload was created
     * @param array $response - The decoded response body
     */
    final public function __construct(Request\Base $request, array $response)
    {
        $responseObject = $this->getResponseFromRequest($request);
        $this->initialiseResponse($responseObject, $response);
    }

    /**
     * Return the appropriate response object for the request type
     * 
     * @param  Request\Base $request
     * 
     * @throws Exception\NotSupported
     *
     * @return Base
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
     *
     * @param  Base $responseObject
     *
     * @param  array $response
     * 
     * @return void
     */
    private function initialiseResponse(Base $responseObject, array $response)
    {
        $responseObject->setResponseArray($response);
        $this->responseObject = $responseObject;
    }

    /**
     * Return the response object
     * 
     * @return Base
     */
    final public function getResponse()
    {
        return $this->responseObject;
    }
}
