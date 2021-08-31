<?php

namespace App\Model\Shared\Infrastructure;

class ApiResponseData
{
    /**
     * Status of the response
     */
    public bool $success;

    /**
     * A string with extra info about the response
     */
    public string $message;

    /**
     * Can be null.
     * Stores the error code if something was wrong
     */
    public ?int $errorCode;

    /**
     * Data to be returned to the client
     * @var mixed $data
     */
    public $data;

    /**
     * @param boolean $success
     * @param string $message
     * @param mixed $data
     * @param integer|null $errorCode
     */
    public function __construct(bool $success, string $message, $data, ?int $errorCode = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->errorCode = $errorCode;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'errorCode' => $this->errorCode,
            'data' => $this->data
        ];
    }
}
