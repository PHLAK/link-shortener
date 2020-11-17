<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /** Run the migrations. */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 64);
            $table->string('title', 256)->nullable();
            $table->string('url', 2048);
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->unique('slug');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /** Reverse the migrations. */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
