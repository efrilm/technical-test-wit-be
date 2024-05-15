<?php

namespace App\Providers;

use App\Services\Employee\EmployeeService;
use App\Services\Employee\EmployeeServiceImpl;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeService::class, EmployeeServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
