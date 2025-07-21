<?php

namespace App\Console\Commands;

use App\Jobs\ProcessPaymentJob;
use App\Models\Expense;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class PaymentsProcessApprovedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:process-approved';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue all approved expenses for payment processing.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Finding approved expenses to queue for payment...');

        $approvedExpenses = Expense::where('status', 'approved')
            ->whereDoesntHave('payment')
            ->get();

        if ($approvedExpenses->isEmpty()) {
            $this->info('No new approved expenses to process.');
            return 0;
        }

        foreach ($approvedExpenses as $expense) {
            Log::info("About to dispatch job for expense ID: {$expense->id}");
            ProcessPaymentJob::dispatch($expense->id);
            Log::info("Job dispatched for expense ID: {$expense->id}");
        }

        $this->info("{$approvedExpenses->count()} approved expenses have been queued for payment.");
        return 0;
    }
}
