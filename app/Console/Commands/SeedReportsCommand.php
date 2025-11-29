<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\Reporting\Enums\ReportStatus;

class SeedReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:seed-stress {count=3000000} {batch=5000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed a large number of generated reports for stress testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');
        $batchSize = (int) $this->argument('batch');

        // Increase default batch size if not specified or too small for high volume
        if ($batchSize < 1000) {
            $batchSize = 5000;
        }

        $this->info("Starting stress seed of {$count} analytics data records...");
        
        // Disable query logging to save memory
        DB::disableQueryLog();

        $this->output->progressStart($count);

        $batches = ceil($count / $batchSize);
        
        $eventTypes = ['purchase', 'signup', 'view', 'click', 'add_to_cart'];

        for ($i = 0; $i < $batches; $i++) {
            $data = [];
            $currentBatchSize = min($batchSize, $count - ($i * $batchSize));

            for ($j = 0; $j < $currentBatchSize; $j++) {
                $eventType = $eventTypes[array_rand($eventTypes)];
                $data[] = [
                    'event_type' => $eventType,
                    'value' => $eventType === 'purchase' ? rand(10, 1000) : null,
                    'metadata' => json_encode([
                        'device' => ['mobile', 'desktop', 'tablet'][rand(0, 2)],
                        'browser' => ['chrome', 'firefox', 'safari'][rand(0, 2)],
                        'source' => ['google', 'facebook', 'direct'][rand(0, 2)],
                    ]),
                    'created_at' => now('Africa/Cairo')->subDays(rand(0, 365))->subSeconds(rand(0, 86400))->toDateTimeString(),
                ];
            }

            // Chunk inserts to avoid "too many SQL variables" error (SQLite limit)
            // 100 rows * 4 columns = 400 variables (Safe for 999 limit)
            foreach (array_chunk($data, 100) as $chunk) {
                DB::table('analytics_data')->insert($chunk);
            }
            
            $this->output->progressAdvance($currentBatchSize);

            // Help PHP garbage collector
            unset($data);
            if ($i % 10 === 0) {
                gc_collect_cycles();
            }
        }

        $this->output->progressFinish();
        $this->info('Analytics data seed completed successfully.');
    }
}
