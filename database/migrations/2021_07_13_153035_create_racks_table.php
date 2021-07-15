<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('racks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('warehouse_id');
            $table->string('name');

            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
        Schema::dropIfExists('racks');
    }
}
