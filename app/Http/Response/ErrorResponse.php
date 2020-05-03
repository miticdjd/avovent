<?php

namespace App\Http\Response;

use Illuminate\Support\MessageBag;

/**
 * Identify that response is not successfully finished.
 */
class ErrorResponse extends BaseResponse
{
    /**
     * @var boolean
     */
    private $success = false;

    public function __construct($resource = null)
    {
        parent::__construct($resource);

        $this->addAdditional('success', $this->success);
    }

    /**
     * Set errors
     * @param MessageBag $errors
     * @return ErrorResponse
     */
    public function setErrors(MessageBag $errors)
    {
        $this->addAdditional('errors', $errors);

        return $this;
    }
}
