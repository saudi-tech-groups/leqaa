<?php

namespace App\Notifications;

use App\VerificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerificationRequested extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\VerificationToken
     */
    private $token;

    public function __construct(VerificationToken $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('verify', $this->token->token);

        return (new MailMessage())
            ->subject(__('Email verification'))
            ->greeting(__('Hello!'))
            ->line(trans('auth.phrases.user_welcome', ['name' => $notifiable->name]))
            ->line(trans('auth.phrases.verify_email'))
            ->action(trans('auth.actions.verify_email'), $url);
    }
}
