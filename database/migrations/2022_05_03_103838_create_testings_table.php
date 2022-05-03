<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestingsTable extends Migration {

    public function up() {
        Schema::create('testings', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('creator_id')->unsigned();

            $table->string('real_id');
            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('testings');
    }
}
