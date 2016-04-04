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
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => Lang::get('fes.blog::lang.plugin.name'),
            'description' => Lang::get('fes.blog::lang.plugin.description'),
            'author'      => 'Fes',
            'icon'        => 'icon-leaf'
        ];
    }

    public function boot()
    {

        PostsController::extendFormFields(function ($form, $model, $context) {

            if (! $model instanceof PostModel) {
                return;
            }

            $form->addSecondaryTabFields([
                'results' => [
                    'label' => 'Results',
                    'type' => 'markdown',
                    'size' => 'huge',
                    'mode' => 'split',
                    'tab' =>  Lang::get('fes.blog::lang.posts.tab_results')
                ]


            ]);

        });

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Fes\Blog\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {

        return [
            'fes.blog.some_permission' => [
                'tab' => 'Blog',
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
                'icon'        => 'icon-leaf',
                'permissions' => ['fes.blog.*'],
                'order'       => 500,
            ],
        ];
    }
}
