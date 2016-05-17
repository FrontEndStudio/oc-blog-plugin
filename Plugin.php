<?php namespace Fes\Blog;

use Backend;
use System\Classes\PluginBase;

use Lang;
use RainLab\Blog\Models\Post as PostModel;
use RainLab\Blog\Controllers\Posts as PostsController;
use Fes\Blog\Models\Post as BlogModel;

/**
 * Blog Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['RainLab.Blog'];

    /**
     * Returns information about the plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => Lang::get('fes.blog::lang.plugin.name'),
            'description' => Lang::get('fes.blog::lang.plugin.description'),
            'author'      => 'FrontEndStudio',
            'icon'        => 'icon-pencil',
            'homepage'    => 'https://github.com/FrontEndStudio/oc-blog-plugin'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {

        PostsController::extendFormFields(function ($form, $model, $context) {

            if (! $model instanceof PostModel) {
                return;
            }

            $form->addSecondaryTabFields([
                'results' => [
                    'label' => Lang::get('fes.blog::lang.posts.tab_results'),
                    'type' => 'markdown',
                    'size' => 'huge',
                    'mode' => 'split',
                    'tab' =>  Lang::get('fes.blog::lang.posts.tab_results')
                ]


            ]);

        });

    }

    /**
     * Register andy front-end components use by this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Fes\Blog\Components\Post' => 'fesPost'
        ];

    }

    /**
     * Registers any front-end snippets implemented in this plugin.
     *
     * @return array
     */
    public function registerPageSnippets()
    {
        return [
            'RainLab\Blog\Components\Categories' => 'categories',
            'RainLab\Blog\Components\Post' => 'post',
            'RainLab\Blog\Components\Posts' => 'posts'
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [];

        return [
            'fes.blog.some_permission' => [
                'tab' => Lang::get('fes.blog::lang.plugin.name'),
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {

        return [];

        return [
            'blog' => [
                'label'       => 'Blog',
                'url'         => Backend::url('fes/blog/mycontroller'),
                'icon'        => 'icon-pencil',
                'permissions' => ['fes.blog.*'],
                'order'       => 500,
            ],
        ];
    }
}
