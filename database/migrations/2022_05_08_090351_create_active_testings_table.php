<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveTestingsTable extends Migration {

    public function up() {
        Schema::create('active_testings', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('testing_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();

            $table->string('title');
            $table->string('access_code');

            $table->softDeletes();

            $table->boolean('show_user_answers');
            $table->boolean('show_correct_answers');

            $table->integer('max_rating');

            $table->foreign('testing_id')->references('id')->on('testings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('active_testings');
    }
}
