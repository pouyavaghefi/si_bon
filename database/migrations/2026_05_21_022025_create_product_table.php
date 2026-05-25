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
        /*
        |--------------------------------------------------------------------------
        | Product Categories
        |--------------------------------------------------------------------------
        */

        Schema::create('product_categories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('product_categories')
                ->nullOnDelete();

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->string('image')
                ->nullable();

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Brands
        |--------------------------------------------------------------------------
        */

        Schema::create('brands', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->string('logo')
                ->nullable();

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Products
        |--------------------------------------------------------------------------
        */

        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('product_categories')
                ->nullOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->text('short_description')
                ->nullable();

            $table->longText('description')
                ->nullable();

            $table->decimal('price', 15, 2)
                ->default(0);

            $table->decimal('discount_price', 15, 2)
                ->nullable();

            $table->enum('sale_unit', [
                'meter',
                'number',
                'roll',
                'square_meter',
                'kg',
                'package',
                'hour',
                'service'
            ])->default('number');

            $table->integer('stock')
                ->default(0);

            $table->integer('min_order')
                ->default(1);

            $table->string('delivery_time')
                ->nullable();

            $table->enum('status', [
                'draft',
                'published',
                'inactive'
            ])->default('draft');

            $table->boolean('is_featured')
                ->default(false);

            $table->boolean('show_price')
                ->default(true);

            $table->boolean('allow_order')
                ->default(true);

            $table->string('meta_title')
                ->nullable();

            $table->text('meta_keywords')
                ->nullable();

            $table->text('meta_description')
                ->nullable();

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Product Images
        |--------------------------------------------------------------------------
        */

        Schema::create('product_images', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('image');

            $table->boolean('is_main')
                ->default(false);

            $table->integer('sort_order')
                ->default(0);

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Product Options
        |--------------------------------------------------------------------------
        */

        Schema::create('product_options', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('title');

            $table->enum('type', [
                'select',
                'radio',
                'checkbox',
                'number',
                'text'
            ]);

            $table->boolean('is_required')
                ->default(false);

            $table->integer('sort_order')
                ->default(0);

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Product Option Values
        |--------------------------------------------------------------------------
        */

        Schema::create('product_option_values', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_option_id')
                ->constrained('product_options')
                ->cascadeOnDelete();

            $table->string('title');

            $table->decimal('price', 15, 2)
                ->default(0);

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Product Specifications
        |--------------------------------------------------------------------------
        */

        Schema::create('product_specifications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('key');

            $table->string('value');

            $table->integer('sort_order')
                ->default(0);

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Related Products
        |--------------------------------------------------------------------------
        */

        Schema::create('related_products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('related_product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Product Tags
        |--------------------------------------------------------------------------
        */

        Schema::create('product_tags', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | Product Tag Items
        |--------------------------------------------------------------------------
        */

        Schema::create('product_tag_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('tag_id')
                ->constrained('product_tags')
                ->cascadeOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tag_items');

        Schema::dropIfExists('product_tags');

        Schema::dropIfExists('related_products');

        Schema::dropIfExists('product_specifications');

        Schema::dropIfExists('product_option_values');

        Schema::dropIfExists('product_options');

        Schema::dropIfExists('product_images');

        Schema::dropIfExists('products');

        Schema::dropIfExists('brands');

        Schema::dropIfExists('product_categories');
    }
};
