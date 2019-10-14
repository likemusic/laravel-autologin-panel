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

    private function __construct(Application $app)
    {
        parent::__construct($app);
        $this->pluginBaseDir = realpath(__DIR__ . '/../../');
    }

    public function boot()
    {
        $this->loadRoutesFrom($this->pathTo('routes/web.php'));
        $this->loadViewsFrom($this->pathTo('resources/views'), 'todolist');
        $this->publishes([
            $this->pathTo('resources/views') => base_path('resources/views/wisdmlabs/todolist'),
        ]);
    }

    private function pathTo($path)
    {
        return $this->pluginBaseDir . DIRECTORY_SEPARATOR . $path;
    }
}
