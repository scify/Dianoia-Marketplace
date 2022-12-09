<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotice extends Notification implements ShouldQueue {
    use Queueable;

    protected $resource;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resource) {
        $this->afterCommit = true;
        $this->resource = $resource;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $url = Route('administration.exercises_management') . '#pending';

        return (new MailMessage)
            ->greeting('Greetings Admin! Please review the submitted exercise below and approve or reject it. Press the button below to view the submitted exercise on the marketplace')
            ->subject('DiAnoia Marketplace Administration: Confirm New Exercise Submission / ' . $this->resource->name)
            ->line("Exercise ID:\t" . $this->resource->id)
            ->line("Exercise Name:\t" . $this->resource->name)
            ->line("User Name:\t" . $notifiable->name)
            ->line("User Email:\t" . $notifiable->email)
            ->line("User ID:\t" . $this->resource->creator_user_id)
            ->action('Manage Submitted Exercises', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
