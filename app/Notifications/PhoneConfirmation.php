<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Messagebird\MessagebirdMessage;

class PhoneConfirmation extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var
     */
    private $code;
    /**
     * @var
     */
    private $recipient;

    /**
     * Create a new notification instance.
     *
     * @param $recipient
     * @param $code
     */
    public function __construct($recipient, $code)
    {
        $this->code = $code;
        $this->recipient = $recipient;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [MessagebirdChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
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

    public function toMessageBird($notifiable)
    {
        return (
            MessagebirdMessage::create(trans('auth.sms', ['code' => $this->code]))
                ->setRecipients($this->recipient)
        );
    }
}
