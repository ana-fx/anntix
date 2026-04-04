<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\Events\JobFailed;

class FailedJobAlert extends Mailable
{
    // Intentionally NOT implementing ShouldQueue — must send synchronously
    // to avoid infinite loop when the queue itself is broken.

    public string $jobName;
    public string $queueName;
    public string $errorMessage;
    public string $failedAt;
    public string $connectionName;

    public function __construct(JobFailed $event)
    {
        $payload = method_exists($event->job, 'payload') ? $event->job->payload() : [];

        $this->jobName        = $payload['displayName'] ?? $event->job->getName();
        $this->queueName      = $event->job->getQueue();
        $this->connectionName = $event->connectionName;
        $this->errorMessage   = $event->exception->getMessage();
        $this->failedAt       = now()->format('d M Y H:i:s');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[ALERT] Queue Job Gagal — ' . $this->failedAt,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.failed-job-alert',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
