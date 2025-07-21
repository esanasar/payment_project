<?php

namespace App\Listeners;

use App\Events\ExpenseRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRejectionNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExpenseRejected $event): void
    {
        $user = $event->expense->user;
        $reason = $event->expense->rejection_reason;

        // 1. Send SMS (hypothetical)
        // Log::info("Sending rejection SMS to user {$user->id}");
        // SmsApiService::send(
        //     $user->phone_number,
        //     "درخواست هزینه شما با دلیل '{$reason}' رد شد."
        // );

        // 2. Send Email (hypothetical, using Laravel's mail capabilities)
        // Log::info("Sending rejection email to user {$user->id}");
        /*
        try {
            Mail::raw("درخواست هزینه شما با دلیل '{$reason}' رد شد.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('اطلاعیه رد درخواست هزینه');
            });
        } catch (\Exception $e) {
            Log::error("Failed to send rejection email to user {$user->id}: " . $e->getMessage());
        }
        */
    }
}
