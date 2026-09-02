<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('candidate_volunteerings')) {
            Schema::create('candidate_volunteerings', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('organization');
                $table->string('role')->nullable();

                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();

                $table->text('description')->nullable();

                $table->timestamps();

                $table->index('user_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_volunteerings');
    }
};