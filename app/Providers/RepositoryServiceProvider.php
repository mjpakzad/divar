<?php


namespace App\Providers;

use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Repositories\SettingRepository;

class RepositoryServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}