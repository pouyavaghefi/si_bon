<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'job')) {
                $table->string('job')->nullable()->after('gender');
            }

            if (!Schema::hasColumn('members', 'refund')) {
                $table->string('refund')->nullable()->after('job');
            }

            if (!Schema::hasColumn('members', 'economic_code')) {
                $table->string('economic_code', 50)->nullable()->after('national_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'job',
                'refund',
                'economic_code',
            ]);
        });
    }
};
