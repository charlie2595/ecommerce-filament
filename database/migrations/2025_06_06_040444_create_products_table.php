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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->integer('quantity')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_ppn')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->string('thumbnail')->nullable();
            $table->integer('unit_id')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('brand_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
