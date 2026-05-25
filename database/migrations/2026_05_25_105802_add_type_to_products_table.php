<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('type', ['taki', 'print'])
                ->default('taki')
                ->after('brand_id');
            $table->json('allowed_extensions')->nullable()->after('delivery_time');
            $table->integer('max_upload_size')->nullable()->after('allowed_extensions');
            $table->boolean('require_upload')->default(true)->after('max_upload_size');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'allowed_extensions',
                'max_upload_size',
                'require_upload',
            ]);
        });
    }
};
