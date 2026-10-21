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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->float('aiGeneratedScore')->nullable();
            $table->text('aiGeneratedFeedback')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();

            //Relationships

            $table->uuid('job_id');
            $table->foreign('job_id')->references('id')->on('job_vacancies')->onDelete('restrict');

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->uuid('resume_id');
            $table->foreign('resume_id')->references('id')->on('resumes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};

        
