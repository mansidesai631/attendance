<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\MChallan;
use App\Helpers\Helper;

class SendMchallan extends Mailable
{
    use Queueable, SerializesModels;

    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $challan = MChallan::with('employee.work.department','employee','site','wards','employee.work.designation')->where('id',$this->id)->first();
        $fine_in_words = ucfirst(Helper::getIndianCurrency($challan->amount_of_fine));
        return $this->view('emails.mchallan')
            ->subject('Your Mchallan Receipt')
            ->with([
                'challan' => $challan,
                'fine_in_words' => $fine_in_words
            ]);
    }
}
