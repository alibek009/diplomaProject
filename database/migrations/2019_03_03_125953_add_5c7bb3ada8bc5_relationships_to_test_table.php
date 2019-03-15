<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c7bb3ada8bc5RelationshipsToTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function(Blueprint $table) {
            if (!Schema::hasColumn('tests', 'course_id')) {
                $table->integer('course_id')->unsigned()->nullable();
                $table->foreign('course_id', '273012_5c7bb3ab781dd')->references('id')->on('courses')->onDelete('cascade');
                }
                if (!Schema::hasColumn('tests', 'lesson_id')) {
                $table->integer('lesson_id')->unsigned()->nullable();
                $table->foreign('lesson_id', '273012_5c7bb3ab8be19')->references('id')->on('lessons')->onDelete('cascade');
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
        Schema::table('tests', function(Blueprint $table) {
            
        });
    }
}
