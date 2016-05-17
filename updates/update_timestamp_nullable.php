<?php namespace Fes\Blog\Updates;

use Schema;
use DbDongle;
use October\Rain\Database\Updates\Migration;

class UpdateTimestampsNullable extends Migration
{
    public function up()
    {
        DbDongle::disableStrictMode();
        DbDongle::convertTimestamps('fes_blog_posts');
    }

    public function down()
    {
    }
}
