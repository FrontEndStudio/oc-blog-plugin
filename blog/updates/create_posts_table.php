<?php namespace Fes\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePostsTable extends Migration
{

    public function up()
    {
        Schema::create('fes_blog_posts', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('post_id')->unsigned()->index();
            $table->text('results')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fes_blog_posts');
    }
}
