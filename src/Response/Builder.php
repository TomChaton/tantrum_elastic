<?php

namespace tantrum_elastic\Response;

use tantrum_elastic\Payload;
use tantrum_elastic\Exception;

/**
 * This is a factory class for pairing requests with their appropriate response handlers
 * @package tantrum_elastic\Response
 */
class Builder
{
    /** @var Base */
    private $responseObject;

    /**
     * Create and initialise a response object
     *
     * @param Payload\Base $request - The request object from which the payload was created
     * @param array $response - The decoded response body
     */
    final public function __construct(Payload\Base $request, array $response)
    {
        $responseObject = $this->getResponseFromRequest($request);
        $this->initialiseResponse($responseObject, $response);
    }

    /**
     * Return the appropriate response object for the request type
     * 
     * @param  Payload\Base $request
     * 
     * @throws Exception\NotSupported
     *
     * @return Base
     */
    private function getResponseFromRequest(Payload\Base $request)
    {
        $type = $request->getType();
        switch($type) {
            case Payload\Base::TYPE_SEARCH:
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
