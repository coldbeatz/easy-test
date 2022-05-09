<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration {

    public function up() {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('testing_id')->unsigned();

            $table->text('question');
            $table->text('json_answers');
            $table->boolean('response_type');

            $table->softDeletes();

            $table->foreign('testing_id')->references('id')->on('testings')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('questions');
    }
}
