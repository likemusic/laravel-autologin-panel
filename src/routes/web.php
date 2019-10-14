<?php

use Likemusic\Laravel\AutologinPanel\Http\Controllers\AutologinController;

Route::get('autologin/{user_id}', AutologinController::class . '@autologin')->name('autologin');
