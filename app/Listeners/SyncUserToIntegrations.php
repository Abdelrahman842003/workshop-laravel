<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncUserToIntegrations
{
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
    public function handle(UserRegistered $event): void
    {
        // Find all active integrations
        $integrations = \App\Models\Integration::where('status', 'active')->get();

        foreach ($integrations as $integration) {
            // Dispatch job for this integration with the new user
            \App\Services\Integrations\Jobs\SyncDataJob::dispatch($integration, collect([$event->user]));
        }
    }
}
