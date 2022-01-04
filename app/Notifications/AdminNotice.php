<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\BusinessLogicLayer\Resource\ResourcesPackageManager;

class AdminNotice extends Notification implements ShouldQueue
{
    use Queueable;
    protected $resource;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resource)
    {
        $this->afterCommit = true;
        $this->resource = $resource;

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
        $url = Route('administration.exercises_management');
        return (new MailMessage)
            ->greeting('Submitted Exercise Details')
            ->subject('DiAnoia Marketplace: Confirm New Exercise Submission / '.$this->resource->name)
            ->line("Exercise ID:\t".$this->resource->id)
            ->line("Exercise Name:\t".$this->resource->name)
            ->line("User Name:\t".$notifiable->name)
            ->line("User Email:\t".$notifiable->email)
            ->line("User ID:\t".$this->resource->creator_user_id)
            ->action('View Submitted Packages', $url);
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
