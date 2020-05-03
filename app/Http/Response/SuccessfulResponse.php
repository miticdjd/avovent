<?php

namespace App\Http\Response;

/**
 * Identify that response is successful
 */
class SuccessfulResponse extends BaseResponse
{
    /**
     * @OA\Property(property="success", type="boolean")
     * @var boolean
     */
    private $success = true;

    public function __construct($resource = null)
    {
        parent::__construct($resource);

        $this->addAdditional('success', $this->success);
    }
}
