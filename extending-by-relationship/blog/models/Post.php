<?php namespace Fes\Blog\Models;

use Model;

/**
 * Post Model
 */
class Post extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'fes_blog_posts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'post' => ['RainLab\Blog\Models\Post']
    ];

    public static function getFromPost($post)
    {


        if ($post->post) {
            return $post->blog;
        }

        $blog = new static;
        $blog->post = $post;
        $blog->save();
        $post->post = $blog;
        return $blog;

    }
}
