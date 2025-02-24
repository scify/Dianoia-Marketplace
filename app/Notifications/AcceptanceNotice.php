<?php

namespace App\Notifications;

use App\Models\Resource\Resource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptanceNotice extends Notification implements ShouldQueue {
    use Queueable;

    protected Resource $resource;

    protected string $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resource, $username) {
        $this->afterCommit = true;
        $this->resource = $resource;
        $this->username = $username;
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
        $url = Route('resources.my_profile') . '#approved';

        return (new MailMessage)
            ->greeting('Greetings ' . $this->username . '! Thank you for using our platform to support people fighting with dementia.')
            ->subject('Dianoia Marketplace: Your submitted exercise titled "' . $this->resource->name . '" was approved!')
            ->action('See your approved exercises', $url);
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
