<?php

return [

    /**
     * Enter models which can be commented upon.
     */
    'content' => [
        HelloVideo\Models\Video::class
    ],

    /**
     * Enter your user model.
     */
    'user_model' => HelloVideo\User::class,

    /**
     * Get the path to the login route.
     */
    'login_path' => '/'
];
