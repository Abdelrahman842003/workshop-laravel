<?php

namespace App\Services\Integrations\Jobs;

use App\Models\Integration;
use App\Models\User;
use App\Services\Integrations\IntegrationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public function __construct(
        public Integration $integration,
        public ?\Illuminate\Support\Collection $data = null
    ) {}

    public function backoff(): array
    {
        return [10, 30, 60];
    }

    public function handle(IntegrationService $service)
    {
        // Use provided data or fallback to demo logic (latest 10 users)
        $data = $this->data ?? User::latest()->take(10)->get();

        if ($data->isEmpty()) {
            return;
        }

        $service->sync($this->integration, $data);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        // Notify the first admin user (or a specific email)
        $admin = User::first(); // In real app: User::where('role', 'admin')->first()
        
        if ($admin) {
            $admin->notify(new \App\Notifications\IntegrationFailed(
                $this->integration->name,
                $exception->getMessage()
            ));
        }
        
        \Illuminate\Support\Facades\Log::error("SyncDataJob Failed Final: " . $exception->getMessage());
    }
}
