<?php

namespace App\Providers;

use App\Interfaces\AssignedTeacherRepository;
use App\Repositories\AssignedTeacherRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class AssignedTeacherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AssignedTeacherRepository::class, AssignedTeacherRepositoryImpl::class);
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
