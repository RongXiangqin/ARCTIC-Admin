<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFerretAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ferret_albums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            //参照works项目定义
            $table->string('project_code', 20)->nullable();
            $table->integer('project_id')->nullable();
            $table->string('area', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('name', 255);
            $table->integer('project_state')->nullable();

            $table->text('description')->nullable();
            $table->binary('cover_image');
            $table->boolean('display');
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
        Schema::dropIfExists('ferret_albums');
    }
}
