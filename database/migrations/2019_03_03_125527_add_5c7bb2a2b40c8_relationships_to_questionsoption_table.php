<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c7bb2a2b40c8RelationshipsToQuestionsOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions_options', function(Blueprint $table) {
            if (!Schema::hasColumn('questions_options', 'question_id')) {
                $table->integer('question_id')->unsigned()->nullable();
                $table->foreign('question_id', '273011_5c7bb2a07f08b')->references('id')->on('questions')->onDelete('cascade');
                }
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions_options', function(Blueprint $table) {
            
        });
    }
}
