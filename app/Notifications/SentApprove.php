<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SentApprove extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($sender, $approveable)
    {
        $this->sender = $sender;
        $this->approveable = $approveable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $label = str_contains(get_class($this->approveable), 'Well') ? ' el pozo "'.$this->approveable->name.'"' : 'el servicio "'.$this->approveable->well->name.'" - "'.$this->approveable->type->name.'"';
        $entity = str_contains(get_class($this->approveable), 'Well') ? 'well' : 'service';
        return (new MailMessage)
            ->line($sender->name.' ha enviado a aprobación '.$label.'.')
            ->action('Ver', route($entity.'.edit',['id'=>$this->approveable->getKey()]) );
            
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}