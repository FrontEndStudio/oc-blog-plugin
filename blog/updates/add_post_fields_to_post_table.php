<?php namespace Fes\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddPostFieldsToPostTable extends Migration
{

    public function up()
    {
        Schema::table('rainlab_blog_posts', function ($table) {
            $table->text('results')->nullable();
        });
    }

    public function down()
    {
        $table->dropDown([
            'results'
        ]);
        
    }
}
