<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCreatedEmployee extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $name;
    public $user_number;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $password, $user_number)
    {
        $this->password = $password;
        $this->name = $name;
        $this->user_number = $user_number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_employee')
            ->subject('Welcome')
            ->with([
                'user_number' => $this->user_number,
                'name' => $this->name,
                'password' => $this->password
            ]);
    }
}
