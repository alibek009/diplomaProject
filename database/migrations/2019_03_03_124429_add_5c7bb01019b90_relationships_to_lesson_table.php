<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5c7bb01019b90RelationshipsToLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function(Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'course_id')) {
                $table->integer('course_id')->unsigned()->nullable();
                $table->foreign('course_id', '273007_5c7bb00de2ad5')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::table('lessons', function(Blueprint $table) {
            
        });
    }
}
