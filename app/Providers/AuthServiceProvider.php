<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\Impl\AuthServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [AuthService::class];
    }
    /**
    * Register services
    * 
    * @return void
    */
    public function register(): void
    {
        $this->app->singleton(AuthService::class, AuthServiceImpl::class);
    }

    /**
     * Bootstrap services
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
