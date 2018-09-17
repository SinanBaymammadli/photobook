<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumOrderPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_order_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('album_order_id');
            $table->string('url');
            $table->timestamps();

            $table->foreign('album_order_id')->references('id')->on('album_orders')
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
        Schema::dropIfExists('album_order_photos');
    }
}
