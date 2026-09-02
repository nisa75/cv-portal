<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('candidate_profiles')) {
            Schema::table('candidate_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('candidate_profiles', 'headline')) {
                    $table->string('headline')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('candidate_profiles', 'is_public')) {
                    $table->boolean('is_public')->default(true)->after('portfolio');
                }
                if (!Schema::hasColumn('candidate_profiles', 'profile_views_count')) {
                    $table->unsignedInteger('profile_views_count')->default(0)->after('is_public');
                }
            });
        }

        $tables = [
            'candidate_certificates' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('name'); $t->string('issuer')->nullable(); $t->date('issued_at')->nullable();
                $t->string('credential_id')->nullable(); $t->string('credential_url')->nullable();
                $t->text('description')->nullable(); $t->timestamps();
                $t->index('user_id');
            },
            'candidate_courses' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('name'); $t->string('provider')->nullable(); $t->date('completed_at')->nullable();
                $t->string('certificate_url')->nullable(); $t->text('description')->nullable(); $t->timestamps();
                $t->index('user_id');
            },
            'candidate_technical_infos' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('category')->nullable(); $t->string('name'); $t->string('level')->nullable();
                $t->string('years')->nullable(); $t->text('notes')->nullable(); $t->timestamps(); $t->index('user_id');
            },
            'candidate_languages' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('language'); $t->string('level'); $t->string('certificate')->nullable();
                $t->timestamps(); $t->index('user_id');
            },
            'candidate_references' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('name'); $t->string('position')->nullable(); $t->string('company')->nullable();
                $t->string('email')->nullable(); $t->string('phone')->nullable(); $t->text('note')->nullable();
                $t->timestamps(); $t->index('user_id');
            },
            'candidate_projects' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('title'); $t->string('tech_stack')->nullable(); $t->text('description')->nullable();
                $t->string('project_url')->nullable(); $t->string('github_url')->nullable();
                $t->string('image')->nullable(); $t->timestamps(); $t->index('user_id');
            },
            'candidate_volunteering' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('organization'); $t->string('role')->nullable();
                $t->date('start_date')->nullable(); $t->date('end_date')->nullable();
                $t->text('description')->nullable(); $t->timestamps(); $t->index('user_id');
            },
            'candidate_achievements' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('title'); $t->string('organization')->nullable(); $t->date('achieved_at')->nullable();
                $t->text('description')->nullable(); $t->string('url')->nullable(); $t->timestamps(); $t->index('user_id');
            },
            'company_follows' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->foreignId('company_id')->constrained()->cascadeOnDelete();
                $t->timestamps(); $t->unique(['user_id', 'company_id']);
            },
            'profile_views' => function (Blueprint $t) {
                $t->id();
                $t->foreignId('candidate_id')->constrained('users')->cascadeOnDelete();
                $t->foreignId('viewer_id')->nullable()->constrained('users')->nullOnDelete();
                $t->string('ip_address', 45)->nullable();
                $t->string('user_agent', 500)->nullable();
                $t->timestamp('viewed_at');
                $t->index(['candidate_id', 'viewed_at']);
                $t->index(['viewer_id', 'viewed_at']);
            },
            'cover_letters' => function (Blueprint $t) {
                $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
                $t->string('title'); $t->string('job_title')->nullable(); $t->string('company')->nullable();
                $t->text('content'); $t->boolean('is_default')->default(false); $t->timestamps(); $t->index('user_id');
            },
        ];

        foreach ($tables as $name => $callback) {
            if (!Schema::hasTable($name)) Schema::create($name, $callback);
        }
    }

    public function down(): void
    {
        foreach ([
            'cover_letters','profile_views','company_follows','candidate_achievements','candidate_volunteering',
            'candidate_projects','candidate_references','candidate_languages','candidate_technical_infos',
            'candidate_courses','candidate_certificates'
        ] as $table) Schema::dropIfExists($table);
        if (Schema::hasTable('candidate_profiles')) {
            Schema::table('candidate_profiles', function (Blueprint $table) {
                foreach (['headline','is_public','profile_views_count'] as $column) {
                    if (Schema::hasColumn('candidate_profiles', $column)) $table->dropColumn($column);
                }
            });
        }
    }
};
