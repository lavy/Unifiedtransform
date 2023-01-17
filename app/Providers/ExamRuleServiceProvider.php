<?php

namespace App\Providers;

use App\Interfaces\ExamRuleRepository;
use App\Repositories\ExamRuleRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class ExamRuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExamRuleRepository::class, ExamRuleRepositoryImpl::class);
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
