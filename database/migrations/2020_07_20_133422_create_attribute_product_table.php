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
        Schema::create('attribute_product', function (Blueprint $table) {
            $table->id();
            $table->unique(['attribute_id', 'product_id']);
            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_product', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('attribute_product');
    }
};
