<?php namespace Fes\Blog;

use Backend;
use System\Classes\PluginBase;

use RainLab\Blog\Models\Post as PostModel;
use RainLab\Blog\Controllers\Posts as PostsController;
use Fes\Blog\Models\Post as BlogModel;

/**
 * Blog Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Blog',
            'description' => 'No description provided yet...',
            'author'      => 'Fes',
            'icon'        => 'icon-leaf'
        ];
    }

    public function boot()
    {
        PostModel::extend(function ($model) {
            $model->hasOne['post'] = ['Fes\Blog\Models\Post'];
        });

        PostsController::extendFormFields(function ($form, $model, $context) {

            if (! $model instanceof PostModel) {
                return;
            }

            if (! $model->exists) {
                return;
            }

            BlogModel::getFromPost($model);

            $form->addTabFields([

                'post[results]' => [
                    'label' => 'Results',
                    'tab' => 'Profile',
                    'type' => 'textarea'
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
        return []; // Remove this line to activate

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
