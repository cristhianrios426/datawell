<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SentReview extends Notification
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
    public function __construct($sender, $reviewed)
    {
        $this->sender = $sender;
        $this->reviewed = $reviewed;
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
        $label = str_contains(get_class($this->reviewed), 'Well') ? ' el pozo "'.$this->reviewed->name.'"' : 'el servicio "'.$this->reviewed->well->name.'" - "'.$this->reviewed->type->name.'"';
        $entity = str_contains(get_class($this->reviewed), 'Well') ? 'well' : 'service';
        return (new MailMessage)
            ->line($sender->name.' ha enviado una revisión a '.$label.'.')
            ->action('Ver', route($entity.'.edit',['id'=>$this->reviewed->getKey()]) );
            
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