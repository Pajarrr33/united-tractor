<?php

namespace App\Providers;

use App\Services\Impl\JwtServiceImpl;
use App\Services\JwtService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class JwtServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [JwtService::class];
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(JwtService::class, JwtServiceImpl::class);
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
