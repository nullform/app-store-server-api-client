<?php

namespace Nullform\AppStoreServerApiClient\Exceptions;

use Psr\Http\Message\ResponseInterface;

class AppleException extends \Exception
{
    /**
     * @var int
     */
    protected $httpStatus = 0;

    public function __construct(string $message = "", int $code = 0, int $httpStatus = 0)
    {
        parent::__construct($message, $code, null);

        $this->setHttpStatus($httpStatus);
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function setHttpStatus(int $httpStatus): self
    {
        $this->httpStatus = $httpStatus;

        return $this;
    }

    /**
     * Create AppleException instance from App Store Server API response.
     *
     * @param ResponseInterface $response
     * @return static
     */
    public static function fromResponse(ResponseInterface $response): self
    {
        $httpStatus = $response->getStatusCode();
        $contents = $response->getBody()->getContents();
        $errorObject = null;
        if ($contents) {
            $errorObject = \json_decode($contents);
        }
        $errorCode = 0;
        $errorMessage = (string)$response->getReasonPhrase();

        if ($errorObject) {
            if (!empty($errorObject->errorCode)) {
                $errorCode = $errorObject->errorCode;
            }
            if (!empty($errorObject->errorMessage)) {
                $errorMessage = $errorObject->errorMessage;
            }
        }

        return new static($errorMessage, $errorCode, $httpStatus);
    }
}
