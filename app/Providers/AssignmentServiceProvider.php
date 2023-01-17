<?php

namespace App\Providers;

use App\Interfaces\AssignmentRepository;
use App\Repositories\AssignmentRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class AssignmentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AssignmentRepository::class. AssignmentRepositoryImpl::class);
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
