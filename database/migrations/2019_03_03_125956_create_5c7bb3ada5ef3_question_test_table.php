<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create5c7bb3ada5ef3QuestionTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('question_test')) {
            Schema::create('question_test', function (Blueprint $table) {
                $table->integer('question_id')->unsigned()->nullable();
                $table->foreign('question_id', 'fk_p_273009_273012_test_q_5c7bb3ada608b')->references('id')->on('questions')->onDelete('cascade');
                $table->integer('test_id')->unsigned()->nullable();
                $table->foreign('test_id', 'fk_p_273012_273009_questi_5c7bb3ada616f')->references('id')->on('tests')->onDelete('cascade');
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_test');
    }
}
