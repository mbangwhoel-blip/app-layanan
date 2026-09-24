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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_number', 50)->unique();
            $table->foreignId('complaint_category_id')->constrained('complaint_categories');
            $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reporter_name');
            $table->string('reporter_phone', 20);
            $table->text('location_detail')->nullable();
            $table->foreignId('village_id')->constrained('villages');
            $table->text('description');
            $table->timestampTz('reported_at')->nullable();
            $table->foreignId('officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 50)->default('received');
            $table->text('verification_result')->nullable();
            $table->text('action_taken')->nullable();
            $table->foreignId('duplicate_of_id')->nullable()->constrained('complaints')->nullOnDelete();
            $table->timestampTz('resolved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('village_id');
            $table->index('complaint_category_id');
            $table->index('reported_at');
            $table->index('officer_id');
            $table->index('reporter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
