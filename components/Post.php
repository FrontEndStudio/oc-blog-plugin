<?php

namespace Fes\Blog\Components;

use Db;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;

use RainLab\Blog\Components\Post as RainLabPost;
use RainLab\Blog\Models\Post as BlogPost;
use RainLab\Blog\Models\Category as BlogCategory;

/**
 * Class Post
 *
 * @package Fes/Blog/Components
 */
class Post extends RainLabPost
{

    public $postPage;
    public $post;
    public $prev;
    public $next;

    /**
     * Override of original method
     * add the post URL to the post entity
     * add getPrevPost, getNextPost
     *
     * @return mixed
     */
    protected function loadPost()
    {

        $slug = $this->property('slug');
        $postPage = $this->property('postPage');
        $orderBy = $this->getOrderBy($this->property('sortOrder'));

        $slugs = BlogCategory::lists('slug');

        // get the first blog post containing the :slug (category.slug)
        // OR get the blog post containing the :slug (blog.slug)

        if (in_array($slug, array_values($slugs))) {

            $category = BlogCategory::where('slug', $slug)->first();

            if ($orderBy[1] == 'desc') {
                $post = $category
                        ->posts
                        ->sortByDesc($orderBy[0])
                        ->first();
            } else {
                $post = $category
                        ->posts
                        ->sortBy($orderBy[0])
                        ->first();
            }

        } else {

            $post = BlogPost::isPublished()
                    ->where('slug', $slug)
                    ->orderBy($orderBy[0], $orderBy[1])
                    ->first();
        }

        /*
         * Add a "url" helper attribute for linking to each category
         */
        if ($post && $post->categories->count()) {
            $post->categories->each(function ($category) {
                $category->setUrl($this->categoryPage, $this->controller);
            });
        }

        if ($post instanceof BlogPost) {
            $post->setUrl($postPage, $this->controller);
        }

        $this->post = $post;

        if (count($this->post)) {
            $this->prev = $this->page['prev'] = $this->getPrevPost($orderBy);
            $this->next = $this->page['next'] = $this->getNextPost($orderBy);
        }

        return $post;
    }

    /**
     * getSortOrder by checking the allowedSortingOptions
     *
     * @return array
     */
    public function getOrderBy($sort)
    {

        $orderBy = array('published_at', 'desc');

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {

            if (in_array($_sort, array_keys(BlogPost::$allowedSortingOptions))) {
                $parts = explode(' ', $_sort);

                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }

                list($sortField, $sortDirection) = $parts;

                if ($sortField == 'random') {
                    $sortField = DB::raw('RAND()');
                }

                $orderBy[0] = $sortField;
                $orderBy[1] = $sortDirection;

            }

        }

        return $orderBy;

    }


    /**
     * Override of original method
     * - add new setting for the post page id
     *
     * @return array
     */
    public function defineProperties()
    {
        $parentProps = parent::defineProperties();

        $properties = array_merge(
            $parentProps,
            [
                'postPage' => [
                    'title'       => 'rainlab.blog::lang.settings.posts_post',
                    'description' => 'rainlab.blog::lang.settings.posts_post_description',
                    'type'        => 'dropdown',
                    'default'     => 'blog/post',
                    'group'       => 'Links',
                ],
                'sortOrder' => [
                    'title'       => 'rainlab.blog::lang.settings.posts_order',
                    'description' => 'rainlab.blog::lang.settings.posts_order_description',
                    'type'        => 'dropdown',
                    'default'     => 'published_at desc'
                ]
            ]
        );

        return is_array($properties) ? $properties : $parentProps;

    }

    /**
     * Retrieve the postPage properties
     *
     * @return string
     */
    public function getPostPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * Retrieve the sortOrder properties
     *
     * @return string
     */
    public function getSortOrderOptions()
    {
        return BlogPost::$allowedSortingOptions;
    }

    /**
     * Retrieve the prevPost
     *
     * @return mixed
     */
    public function getPrevPost($orderBy)
    {

        $sortValue = $this->post->toArray()[$orderBy[0]];
        $postPage = $this->property('postPage');

        if ($orderBy[1] == 'asc') {
            $sortDirection = 'desc';
        } else {
            $sortDirection = 'asc';
        }

        $post = BlogPost::isPublished()
                ->where($orderBy[0], '>', $sortValue)
                ->orderBy($orderBy[0], $sortDirection)
                ->first();

        if ($post instanceof BlogPost) {
            $post->setUrl($postPage, $this->controller);
        }

        return $post;
    }

    /**
     * Retrieve the nextPost
     *
     * @return mixed
     */
    public function getNextPost($orderBy)
    {

        $sortValue = $this->post->toArray()[$orderBy[0]];
        $postPage = $this->property('postPage');

        $post = BlogPost::isPublished()
                ->where($orderBy[0], '<', $sortValue)
                ->orderBy($orderBy[0], $orderBy[1])
                ->first();

        if ($post instanceof BlogPost) {
            $post->setUrl($postPage, $this->controller);
        }

        return $post;
    }
}
