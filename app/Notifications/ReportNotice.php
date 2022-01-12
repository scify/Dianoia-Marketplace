<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Resource\Resource;
use App\Models\User;
class ReportNotice extends Notification implements ShouldQueue
{
    use Queueable;
    protected Resource $resource;
    protected String $reportComment;
    protected String $reportReason;
    protected User $creator;
    protected User $reporter;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resource, $reportComment, $reportReason, $creator, $reporter)
    {
        $this->afterCommit = true;
        $this->resource = $resource;
        $this->rejectionReason= $reportReason;
        $this->rejectionMessage = $reportComment;
        $this->creator = $creator;
        $this->reporter = $reporter;
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

        $url = Route('administration.exercises_management') . '#pending';
        return (new MailMessage)
            ->greeting('Greetings Admin! Please review the reported exercise')
            ->subject('DiAnoia Marketplace Administration: Exercise REPORTED /  ' . $this->resource->name)
            ->line("Exercise ID:\t" . $this->resource->id)
            ->line("Exercise Name:\t" . $this->resource->name)
            ->line("Creator Name:\t" . $notifiable->name)
            ->line("Creator Email:\t" . $notifiable->email)
            ->line("Creator ID:\t" . $this->resource->creator_user_id)
            ->line("")
            ->line("Reporter Name:\t" . $notifiable->reporter->name)
            ->line("Reporter Email:\t" . $notifiable->reporter->email)
            ->line("Reporter ID:\t" . $this->reporter->id)
            ->action('Manage Submitted Exercises', $url);
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
