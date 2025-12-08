<?php

namespace App\Providers;

use App\Models\ActivityLog;

use App\Models\Setting;
use App\Models\User;
use App\Observers\ActivityLogger;
use App\Http\View\Composers\NotificationComposer;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Http\Kernel;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract; // Added
use App\Http\Responses\LoginResponse; // Added

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponseContract::class, app(LoginResponse::class)); // Added
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Kernel $kernel): void // Added Kernel $kernel
    {
        Setting::observe(ActivityLogger::class);
        User::observe(ActivityLogger::class);
        Role::observe(ActivityLogger::class);
        Permission::observe(ActivityLogger::class);

        // Register global middleware for page view logging
        $kernel->pushMiddleware(\App\Http\Middleware\LogPageViewActivity::class); // Added

        // Bind data to views
        View::composer('layouts.admin', NotificationComposer::class);
    }
}
