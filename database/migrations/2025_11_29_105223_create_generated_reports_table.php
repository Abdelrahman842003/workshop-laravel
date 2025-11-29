<?php

use App\Services\Reporting\Enums\ReportStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('generated_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('report_template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('path')->nullable();
            $table->string('format', 10);
            $table->string('status')->default(ReportStatus::PENDING->value)->index();
            $table->timestamp('expires_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_reports');
    }
};
