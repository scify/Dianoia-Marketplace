<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Resource\Resource;

class RejectionNotice extends Notification implements ShouldQueue
{
    use Queueable;
    protected Resource $resource;
    protected String $rejectionMessage;
    protected String $username;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resource, $rejectionMessage, $username)
    {
        $this->afterCommit = true;
        $this->resource = $resource;
        $this->rejectionMessage = $rejectionMessage;
        $this->username = $username;
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
    public function toMail($notifiable){

        $url = Route('resources.my_profile');
        return (new MailMessage)
            ->greeting('Greetings '.$this->username.'! Thank you for using our platform to support people fighting with dementia.')
            ->subject('DiAnoia Marketplace: Exercise Rejection')
            ->line('We regret to inform you that your submitted exercise titled "'.$this->resource->name.'" was rejected by an administrator')
            ->line('Reason for rejection: "'.$this->rejectionMessage.'"')
            ->line("Exercise ID:\t".$this->resource->id)
            ->line("Exercise Name:\t".$this->resource->name)
            ->line("User Name:\t".$notifiable->name)
            ->line("User Email:\t".$notifiable->email)
            ->line("User ID:\t".$this->resource->creator_user_id)
            ->action('View Submitted Exercises', $url);
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
