<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ORM\User;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    public $subject_m;
    protected $message_m;
    protected $request = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $message, $request = null )
    {
            $this->user = $user;
            $this->subject_m = $subject;
            $this->message_m = $message;
            $this->request = $request;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.contact')->with([
                'user'=>$this->user,
                'subject_m'=>$this->subject_m,
                'message_m'=>$this->message_m,
                'request'=>$this->request,
            ])->to($this->user->email)->subject('Has recibido un nuevo mensaje de contacto');
    }
}
