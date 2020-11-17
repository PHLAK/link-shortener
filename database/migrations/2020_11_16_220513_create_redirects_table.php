<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectsTable extends Migration
{
    /** Run the migrations. */
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('link_id');
            $table->string('ip_address', 64)->nullable();
            $table->string('user_agent', 1024)->nullable();
            $table->timestamps();

            $table->foreign('link_id')->references('id')->on('links');
        });
    }

    /** Reverse the migrations. */
    public function down()
    {
        Schema::dropIfExists('redirects');
    }
}
