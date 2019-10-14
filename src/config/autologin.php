<?php

return [
    'model_class_name' => null, // \App\User::class
    'key' => 'email', // Аny field that is unique for user (e.g. `emial`or `id`)
    'values' => [], // `key` values for users in autologin panel
    'name_template' => '{email}', // Template string for naming users in panel (e.g. '{first_name} {last_name}').
    'id_field_name' => 'id', // id field for user (e.g. `id`or `user_id`)
];
