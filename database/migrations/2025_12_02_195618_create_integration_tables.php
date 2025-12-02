<?php

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
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider'); // e.g., salesforce, sap
            $table->text('credentials')->nullable(); // Encrypted in Model (Must be text, not json)
            $table->json('settings')->nullable(); // Config like endpoints
            $table->string('status')->default('active'); // active, inactive, error
            $table->timestamp('last_sync_at')->nullable();
            $table->timestamps();
        });

        Schema::create('integration_field_mappings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('integrations')->onDelete('cascade');
            $table->string('source_field'); // Internal field
            $table->string('target_field'); // External field
            $table->string('default_value')->nullable();
            $table->string('transformation')->nullable(); // e.g., uppercase
            $table->timestamps();
        });

        Schema::create('integration_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained('integrations')->onDelete('cascade');
            $table->string('status'); // success, failed
            $table->integer('records_processed')->default(0);
            $table->json('payload_summary')->nullable();
            $table->json('response_data')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            
            $table->index('occurred_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integration_logs');
        Schema::dropIfExists('integration_field_mappings');
        Schema::dropIfExists('integrations');
    }
};
