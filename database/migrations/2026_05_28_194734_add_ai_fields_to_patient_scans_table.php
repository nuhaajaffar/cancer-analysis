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
        Schema::table('patient_scans', function (Blueprint $table) {
            $table->string('ai_prediction')->nullable();
            $table->decimal('ai_confidence', 5, 2)->nullable();
            $table->string('ai_status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_scans', function (Blueprint $table) {
            //
        });
    }
};
