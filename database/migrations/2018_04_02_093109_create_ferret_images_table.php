<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFerretImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ferret_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_id');
            $table->binary('md5_value');
            $table->date('shot_date')->nullable();
            $table->string('orign_fname')->nullable();
            $table->integer('orign_fsize')->nullable();
            $table->boolean('display');
            $table->json('exif')->nullable();
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
        Schema::dropIfExists('ferret_images');
    }
}
