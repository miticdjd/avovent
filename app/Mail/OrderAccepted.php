<?php

namespace App\Mail;

use Illuminate\Auth\GenericUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Order has been accepted
 */
class OrderAccepted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     * @var GenericUser
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param GenericUser $user
     */
    public function __construct(GenericUser $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('customer.registration');
    }
}
