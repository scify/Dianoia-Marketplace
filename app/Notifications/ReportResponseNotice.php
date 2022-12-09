<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportResponseNotice extends Notification implements ShouldQueue {
    use Queueable;

    protected String $resource_name;
    protected String $response;
    protected String $reporter_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resource_name, $response, $reporter_name) {
        $this->afterCommit = true;
        $this->resource_name = $resource_name;
        $this->response = $response;
        $this->reporter_name = $reporter_name;
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
        $url = Route('resources.my_profile');

        return (new MailMessage)
            ->greeting('Greetings ' . $this->reporter_name . '! Thank you for using our platform to support people fighting with dementia.')
            ->subject('DiAnoia Marketplace: Exercise Report: ' . $this->resource_name)
            ->line('Your feedback is valuable. A moderator responded with the following:')
            ->line($this->response)
            ->action('View Submitted Exercises', $url);
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
