<?php namespace Fes\Blog\Models;

use Model;
use Schema;

/**
 * Category Model
 */
class Category extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'rainlab_blog_categories';

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

    public static function getColumnData($column)
    {

            $columnData = array();
            $columns = Schema::getColumnListing('rainlab_blog_categories');

            if (in_array($column, array_values($columns))) {
                $columnData =  self::lists($column);
            }

            return $columnData;

    }


}
