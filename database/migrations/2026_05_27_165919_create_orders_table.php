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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('status')
                ->default('pending_review');

            $table->string('payment_type')
                ->nullable();

            $table->decimal('total_price', 15, 2)
                ->default(0);

            $table->string('receiver_name')
                ->nullable();

            $table->string('receiver_lastname')
                ->nullable();

            $table->string('receiver_mobile')
                ->nullable();

            $table->string('receiver_phone')
                ->nullable();

            $table->string('postal_code')
                ->nullable();

            $table->string('province')
                ->nullable();

            $table->string('city')
                ->nullable();

            $table->text('address')
                ->nullable();

            $table->string('shipping_method')->nullable();
            $table->decimal('shipping_price', 15, 2)->default(0);

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title')
                ->nullable();

            $table->string('type')
                ->nullable();

            $table->integer('quantity')
                ->default(1);

            $table->decimal('price', 15, 2)
                ->default(0);

            $table->decimal('total', 15, 2)
                ->default(0);

            $table->text('description')
                ->nullable();

            $table->string('file_path')
                ->nullable();

            $table->string('width')
                ->nullable();

            $table->string('height')
                ->nullable();

            $table->longText('options')
                ->nullable();

            $table->longText('options_number')
                ->nullable();

            $table->boolean('installer_required')
                ->nullable();

            $table->string('installer_type')
                ->nullable();

            $table->text('installer_address')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');

        Schema::dropIfExists('orders');
    }
};
