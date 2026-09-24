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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('client_category_id')->constrained('client_categories');
            $table->char('nik', 16)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender', 20); // male, female
            $table->text('address')->nullable();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();
            $table->string('phone', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('nik');
            $table->index('client_category_id');
            $table->index('village_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
