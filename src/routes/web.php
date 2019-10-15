<?php

use Likemusic\Laravel\AutologinPanel\Http\Controllers\AutologinController;
use Likemusic\Laravel\AutologinPanel\Helpers\ConfigProvider;

$configProvider = app(ConfigProvider::class);
$middleware = $configProvider->getRouteMiddleware();

Route::middleware($middleware)->get('autologin/{user_id}', AutologinController::class . '@autologin')->name('autologin');
