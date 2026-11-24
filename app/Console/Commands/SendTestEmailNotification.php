<?php

namespace App\Console\Commands;

use App\Notifications\TestEmailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SendTestEmailNotification extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email-notification:test {email : The address that receives the test email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queues a test email notification, the same way as the app\'s other notifications';

    public function handle(): int {
        $email = (string) $this->argument('email');

        if (Validator::make(['email' => $email], ['email' => ['required', 'email']])->fails()) {
            $this->error("[{$email}] is not a valid email address.");

            return CommandAlias::FAILURE;
        }

        Notification::route('mail', $email)->notify(new TestEmailNotification);

        $connection = config('queue.default');
        $this->info("Queued a test email to [{$email}] on the [{$connection}] queue connection, with the [" . config('mail.default') . '] mailer.');
        if ($connection !== 'sync') {
            $this->line('A queue worker must process the queue before the email is sent.');
        }

        return CommandAlias::SUCCESS;
    }
}
