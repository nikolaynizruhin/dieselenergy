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
        Schema::create('image_product', function (Blueprint $table) {
            $table->id();
            $table->unique(['product_id', 'image_id']);
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('image_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_product', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['image_id']);
        });

        Schema::dropIfExists('image_product');
    }
};
