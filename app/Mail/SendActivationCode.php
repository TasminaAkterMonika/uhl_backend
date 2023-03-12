<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationCode extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $fullname;
    //public $firstname;
    //public $lastname;
    public $active_code;
    public $user_device;
    public $temp_patient_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname, $email,$active_code,$user_device, $temp_patient_id)
    {
        $this->email = $email;
        $this->fullname = $fullname;
        //$this->lastname = $lastname;
        //$this->firstname = $firstname;
        $this->active_code = $active_code;
        $this->user_device = $user_device;
        $this->temp_patient_id = $temp_patient_id;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->from('dev2.bdpl@gmail.com','United Hospital')
                    ->subject("Account Activation Code")
                    ->view('mails.userActivate');
    }
}