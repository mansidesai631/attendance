<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

class SentSMSToCreatedMchallan implements ShouldQueue
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
        $reason = $this->data['reason'] ?? 'breaking the rules';
        $m_no = $this->data['m_unique_id'];
        $amount = $this->data['amount_of_fine'] ?? 0 ;
        $message = "Due to " . $reason . " your M-challan has generated with No: " . $m_no . ", Fine: " . $amount . " Rs/-";

        // // Configuration for send otp using Twilio
        $account_sid = config('services.twilio.sid');
        $auth_token = config('services.twilio.token');
        $twilio_number = config('services.twilio.from');

        $client = new Client($account_sid, $auth_token);
        $client->messages->create('+91'.$this->data['mobile'], 
                     ['from' => $twilio_number, 'body' => $message] );
    }
}
