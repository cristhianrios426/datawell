<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ORM\User;
class ActivationAccount extends Mailable
{

    use Queueable, SerializesModels;

    public $user;
    public $activation_type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $activation_type)
    {   
        $this->user = $user;
        $this->activation_type = $activation_type;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $this->to($this->user->email, $this->user->name);
        if($this->activation_type == User::RENEW_ACTIVATION){
            return $this->view('mails.activation.renew_activation');
        }elseif($this->activation_type == User::GENERATE_ACTIVATION){
            return $this->view('mails.activation.generate_activation');
        }        
    }
}
