<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncAllIntegrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration:sync-all {integration_id? : The ID of the integration to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync historical data for all or specific integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $integrationId = $this->argument('integration_id');
        
        $query = \App\Models\Integration::where('status', 'active');
        
        if ($integrationId) {
            $query->where('id', $integrationId);
        }

        $integrations = $query->get();

        if ($integrations->isEmpty()) {
            $this->error('No active integrations found.');
            return;
        }

        foreach ($integrations as $integration) {
            $this->info("Starting sync for: {$integration->name}");
            
            // Chunk users (e.g. 100 at a time)
            // In a real app, you might filter by 'synced' flag or timestamp
            \App\Models\User::chunk(100, function ($users) use ($integration) {
                \App\Services\Integrations\Jobs\SyncDataJob::dispatch($integration, $users);
                $this->line("  Dispatched job for " . $users->count() . " users.");
            });
        }

        $this->info('All sync jobs dispatched.');
    }
}
