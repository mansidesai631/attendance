<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class SentSMSToCreatedEmployee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = "Hello " . $this->data['name'] . ",\nWe are now using ManekTech, Face Attendance system.\nYou are invited to signup for Manektech-User app:\nUserId:" . $this->data['user_number'] . " \nPassword:" . $this->data['password'];

        // Configuration for send otp using Twilio
        $account_sid = config('services.twilio.sid');
        $auth_token = config('services.twilio.token');
        $twilio_number = config('services.twilio.from');

        $client = new Client($account_sid, $auth_token);
        $client->messages->create('+91'.$this->data['user_number'], 
                 ['from' => $twilio_number, 'body' => $message] );
    }
}
