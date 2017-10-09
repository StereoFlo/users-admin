<?php

namespace Stereoflo\UsersAdmin;

use File;
use Illuminate\Support\ServiceProvider;

class UsersAdminServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->publishes([
            __DIR__ . '/../publish/Middleware/' => app_path('Http/Middleware'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/migrations/' => database_path('migrations'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/Model/' => app_path(),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/Controllers/' => app_path('Http/Controllers'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/resources/' => base_path('resources'),
        ]);

        $this->publishes([
            __DIR__ . '/../views' => base_path('resources/views/vendor/users-admin'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-admin');

        $menus = [];
        if (File::exists(base_path('resources/users-admin/menus.json'))) {
            $menus = json_decode(File::get(base_path('resources/users-admin/menus.json')));
            view()->share('UsersAdminMenus', $menus);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'Stereoflo\UsersAdmin\UsersAdminCommand'
        );
    }
}
