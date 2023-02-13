<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWashTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wash_types', function (Blueprint $table) {
            $table->id();
            $table->string('wash_type')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('weight')->nullable();
            $table->unsignedBigInteger('days')->nullable();
            $table->integer('price')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('wash_types');
    }
}
