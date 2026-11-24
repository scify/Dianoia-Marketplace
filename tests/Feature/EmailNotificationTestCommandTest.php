<?php

namespace Tests\Feature;

use App\Notifications\TestEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailNotificationTestCommandTest extends TestCase {
    public function test_it_sends_a_queued_test_notification_to_the_given_email(): void {
        Notification::fake();

        $this->artisan('email-notification:test', ['email' => 'someone@example.org'])
            ->assertSuccessful();

        Notification::assertSentOnDemand(
            TestEmailNotification::class,
            fn (TestEmailNotification $notification, array $channels, AnonymousNotifiable $notifiable): bool => $channels === ['mail']
                && $notifiable->routes['mail'] === 'someone@example.org'
        );
    }

    public function test_the_notification_uses_the_queue_like_the_other_notifications(): void {
        $this->assertInstanceOf(ShouldQueue::class, new TestEmailNotification);
    }

    public function test_it_rejects_an_invalid_email(): void {
        Notification::fake();

        $this->artisan('email-notification:test', ['email' => 'not-an-email'])
            ->assertFailed();

        Notification::assertNothingSent();
    }

    public function test_the_mail_names_the_app_and_the_environment(): void {
        $mail = (new TestEmailNotification)->toMail(new AnonymousNotifiable);

        $this->assertStringContainsString(config('app.name'), $mail->subject);
        $this->assertContains('Environment: ' . app()->environment(), $mail->introLines);
    }
}
