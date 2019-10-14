<?php

namespace Likemusic\Laravel\AutologinPanel\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AutologinServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private $pluginBaseDir;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->pluginBaseDir = realpath(__DIR__ . '/../../');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            $this->pathTo('config/autologin.php'), 'autologin'
        );
    }

    public function boot()
    {
        $this->loadRoutesFrom($this->pathTo('routes/web.php'));
        $this->loadViewsFrom($this->pathTo('resources/views'), 'autologin');
        $this->publishes([
            $this->pathTo('config/autologin.php') => config_path('autologin.php'),
        ], 'config');

        $this->publishes([
            $this->pathTo('resources/views') => resource_path('views/likemusic/laravel-autologin-panel'),
        ], 'view');

        $this->publishes([
            $this->pathTo('public/js/autologin.js') => public_path('js/autologin.js'),
            $this->pathTo('public/css/autologin.css') => public_path('css/autologin.js'),
            $this->pathTo('public/images/avatar_man.svg') => public_path('images/avatar_man.svg'),
        ], 'public');
    }

    private function pathTo($path)
    {
        return $this->pluginBaseDir . DIRECTORY_SEPARATOR . $path;
    }
}
