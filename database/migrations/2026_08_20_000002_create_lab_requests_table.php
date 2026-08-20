<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('lab_number')->unique();
            $table->string('request_number')->nullable();
            $table->dateTime('request_date');
            $table->dateTime('specimen_date')->nullable();
            $table->dateTime('finished_date')->nullable();
            $table->string('sender_doctor')->nullable();
            $table->string('pathologist_doctor')->nullable();
            $table->string('printed_by')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('draft'); // draft, verified, cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_requests');
    }
};
