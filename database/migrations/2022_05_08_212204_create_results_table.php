<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration {

    public function up() {
        Schema::create('results', function (Blueprint $table) {
            $table->id();

            $table->string('hash')->index()->nullable();

            $table->bigInteger('activate_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->ipAddress('ip');

            $table->text('json_answers')->nullable();

            $table->timestamp('start_time');
            $table->timestamp('completion_time')->nullable();

            $table->integer('rating')->nullable();

            $table->foreign('activate_id')->references('id')->on('active_testings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('results');
    }
}
