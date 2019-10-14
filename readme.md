Add to composer in "require-dev":

```
    "require-dev": {
...
        "likemusic/laravel-autologin-panel": "dev-master"
    },
```

and add to "repositories" section:
```
    "repositories":[
    ...
        {
            "type": "vcs",
            "url": "git@github.com:likemusic/laravel-autologin-panel.git"
        }
    ]
```

Run:
```
php artisan vendor:publish --provider="Likemusic\Laravel\AutologinPanel\Providers\AutologinServiceProvider" --tag=config
php artisan vendor:publish --provider="Likemusic\Laravel\AutologinPanel\Providers\AutologinServiceProvider" --tag=public
```

Add in your page layout or template:
```
    @include('autologin::autologin')
```

In `config/autologin.php` set your User model class:
```
return [
    'model_class_name' => \App\User::class,
    ...
];
```
