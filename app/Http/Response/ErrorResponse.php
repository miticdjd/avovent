<?php

namespace App\Http\Response;

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
}
