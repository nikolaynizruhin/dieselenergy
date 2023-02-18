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
        Schema::create('attribute_category', function (Blueprint $table) {
            $table->id();
            $table->unique(['attribute_id', 'category_id']);
            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('is_featured')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attribute_category', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('attribute_category');
    }
};
