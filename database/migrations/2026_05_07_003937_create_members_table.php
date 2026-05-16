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
        Schema::create('members', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('national_code', 20)->nullable();
            $table->string('company_name')->nullable();

            $table->string('province')->nullable();
            $table->string('city')->nullable();

            $table->text('address')->nullable();

            $table->string('postal_code', 20)->nullable();

            $table->string('phone', 20)->nullable();

            $table->date('birth_date')->nullable();

            $table->enum('gender', [
                'male',
                'female',
                'other'
            ])->nullable();

            $table->boolean('newsletter')->default(false);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
