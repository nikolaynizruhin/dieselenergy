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
            $table->primary(['attribute_id', 'attributable_id', 'attributable_type'], 'attributables_primary');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->morphs('attributable');
            $table->string('value')->nullable();
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
