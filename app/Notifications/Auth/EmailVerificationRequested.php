<?php

namespace App\Notifications\Auth;

use App\User;
use App\UserVerificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationRequested extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\UserVerificationToken
     */
    private $token;

    /**
     * EmailVerificationRequested constructor.
     *
     * @param \App\User                  $user
     * @param \App\UserVerificationToken $token
     */
    public function __construct(User $user, UserVerificationToken $token)
    {
        $this->user = $user;
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
        $url = route('email_verify', [base64_encode($this->user->email), $this->token->token]);

        return (new MailMessage())
            ->subject(__('Email verification'))
            ->greeting(__('Hello!'))
            ->line(trans('auth.phrases.user_welcome', ['name' => $notifiable->name]))
            ->line(trans('auth.phrases.verify_email'))
            ->action(trans('auth.actions.verify_email'), $url);
    }
}
