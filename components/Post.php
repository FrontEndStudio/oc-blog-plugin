<?php

namespace Fes\Blog\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;

use RainLab\Blog\Components\Post as RainLabPost;
use RainLab\Blog\Models\Post as BlogPost;

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

        $post = parent::loadPost();
        $postPage = $this->property('postPage');

        if ($post instanceof BlogPost) {
            $post->setUrl($postPage, $this->controller);
        }

        $this->post = $post;

        $this->prev = $this->page['prev'] = $this->getPrevPost();
        $this->next = $this->page['next'] = $this->getNextPost();

        return $post;
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
     * Retrieve the nextPost
     *
     * @return mixed
     */
    public function getNextPost()
    {

        $id = $this->post->id;
        $postPage = $this->property('postPage');

        $post = BlogPost::isPublished()->where('id', '>', $id)->first();

        if ($post instanceof BlogPost) {
            $post->setUrl($postPage, $this->controller);
        }

        return $post;
    }

    /**
     * Retrieve the prevPost
     *
     * @return mixed
     */
    public function getPrevPost()
    {

        $id = $this->post->id;
        $postPage = $this->property('postPage');

        $post = BlogPost::isPublished()->where('id', '<', $id)->first();

        if ($post instanceof BlogPost) {
            $post->setUrl($postPage, $this->controller);
        }

        return $post;
    }
}
