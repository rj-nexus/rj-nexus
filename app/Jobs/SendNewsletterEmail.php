<?php

namespace App\Jobs;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subscriber;
    public $mailSubject;
    public $mailBody;

    public function __construct(NewsletterSubscriber $subscriber, string $subject, string $body)
    {
        $this->subscriber = $subscriber;
        $this->mailSubject = $subject;
        $this->mailBody = $body;
    }

    public function handle(): void
    {
        if (!$this->subscriber->isActive()) {
            return;
        }

        $unsubscribeUrl = url('/newsletter/unsubscribe/' . $this->subscriber->token);

        $html = $this->mailBody . '<div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280; text-align: center;">'
              . __('If you no longer wish to receive these emails, you can ')
              . '<a href="' . $unsubscribeUrl . '" style="color: #8b5cf6; text-decoration: underline;">' . __('unsubscribe here') . '</a>.</div>';

        Mail::html($html, function ($message) {
            $message->to($this->subscriber->email)
                    ->subject($this->mailSubject);
        });
    }
}
