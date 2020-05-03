<?php

namespace App\Http\Response;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Base response
 */
class BaseResponse extends JsonResource
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data;

    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    /**
     * Add new additional parameter
     * @param string $parameter
     * @param mixed $value
     */
    public function addAdditional(string $parameter, $value)
    {
        $this->additional[$parameter] = $value;
    }

    /**
     * Set message
     * @param string $message
     * @return BaseResponse
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        $this->addAdditional('message', $message);

        return $this;
    }
}
