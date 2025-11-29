<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportTemplate;
use Illuminate\Support\Str;

class ReportTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Monthly Sales Report',
                'report_type' => 'sales',
                'configuration' => [
                    'start_date' => now()->startOfMonth()->toDateString(),
                    'end_date' => now()->endOfMonth()->toDateString(),
                    'columns' => ['value', 'created_at'],
                    'filters' => ['event_type' => 'purchase'],
                ],
            ],
            [
                'name' => 'Weekly Marketing Overview',
                'report_type' => 'marketing',
                'configuration' => [
                    'start_date' => now()->subDays(7)->toDateString(),
                    'end_date' => now()->toDateString(),
                    'columns' => ['event_type', 'metadata'],
                    'filters' => ['event_type' => 'view'],
                ],
            ],
            [
                'name' => 'High Value Transactions',
                'report_type' => 'analytics',
                'configuration' => [
                    'start_date' => now()->subDays(30)->toDateString(),
                    'end_date' => now()->toDateString(),
                    'columns' => ['value', 'created_at', 'metadata'],
                    'filters' => ['min_value' => 1000, 'event_type' => 'purchase'],
                ],
            ],
            [
                'name' => 'New Signups Last 7 Days',
                'report_type' => 'analytics',
                'configuration' => [
                    'start_date' => now()->subDays(7)->toDateString(),
                    'end_date' => now()->toDateString(),
                    'columns' => ['created_at', 'metadata'],
                    'filters' => ['event_type' => 'signup'],
                ],
            ],
            [
                'name' => 'Quarterly Revenue',
                'report_type' => 'sales',
                'configuration' => [
                    'start_date' => now()->firstOfQuarter()->toDateString(),
                    'end_date' => now()->lastOfQuarter()->toDateString(),
                    'columns' => ['value', 'created_at'],
                    'filters' => [],
                ],
            ],
            [
                'name' => 'Daily Activity Log',
                'report_type' => 'analytics',
                'configuration' => [
                    'start_date' => now()->toDateString(),
                    'end_date' => now()->toDateString(),
                    'columns' => ['event_type', 'created_at', 'metadata'],
                    'filters' => [],
                ],
            ],
            [
                'name' => 'Lost Opportunities',
                'report_type' => 'marketing',
                'configuration' => [
                    'start_date' => now()->subDays(14)->toDateString(),
                    'end_date' => now()->toDateString(),
                    'columns' => ['metadata'],
                    'filters' => ['event_type' => 'view'],
                ],
            ],
            [
                'name' => 'Yearly Performance',
                'report_type' => 'sales',
                'configuration' => [
                    'start_date' => now()->startOfYear()->toDateString(),
                    'end_date' => now()->endOfYear()->toDateString(),
                    'columns' => ['value', 'event_type', 'created_at'],
                    'filters' => ['min_value' => 500],
                ],
            ],
            [
                'name' => 'VIP Customer Actions',
                'report_type' => 'analytics',
                'configuration' => [
                    'start_date' => now()->subDays(30)->toDateString(),
                    'end_date' => now()->toDateString(),
                    'columns' => ['event_type', 'value', 'metadata'],
                    'filters' => ['min_value' => 5000],
                ],
            ],
            [
                'name' => 'Recent System Events',
                'report_type' => 'analytics',
                'configuration' => [
                    'start_date' => now()->subDays(3)->toDateString(),
                    'end_date' => now()->toDateString(),
                    'columns' => ['created_at', 'event_type'],
                    'filters' => [],
                ],
            ],
        ];

        foreach ($templates as $template) {
            ReportTemplate::create($template);
        }
    }
}
