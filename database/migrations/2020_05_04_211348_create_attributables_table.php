<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributables', function (Blueprint $table) {
            $table->id();
            $table->unique(['attribute_id', 'attributable_id', 'attributable_type'], 'attributables_primary');
            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->morphs('attributable');
            $table->string('value')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributables', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
        });

        Schema::dropIfExists('attributables');
    }
}
