<?php

namespace App\Providers;

use App\Models\UserResponse;
use App\Services\UserResponseService;
use Illuminate\Support\ServiceProvider;

class UserResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserResponseService::class, function ($app) {
            $userResponse = new UserResponse();

            return new UserResponseService($userResponse);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
