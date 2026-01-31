<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExpireTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate tickets that have passed their end date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = \App\Models\Ticket::where('is_active', true)
            ->where('end_date', '<', now())
            ->update(['is_active' => false]);

        if ($count > 0) {
            $this->info("Successfully deactivated {$count} expired tickets.");
            \Illuminate\Support\Facades\Log::info("ExpiredTickets Command: Deactivated {$count} tickets.");
        } else {
            $this->info("No expired tickets found needed deactivation.");
        }
    }
}
