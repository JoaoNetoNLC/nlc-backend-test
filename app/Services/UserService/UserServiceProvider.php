<?php

declare(strict_types=1);

namespace App\Services\UserService;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
    }
}
