<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_item_id');
            $table->string('url');
            $table->timestamps();

            $table->foreign('order_item_id')->references('id')->on('order_items')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_item_photos');
    }
}
