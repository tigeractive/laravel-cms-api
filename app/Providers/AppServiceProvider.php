<?php

namespace App\Providers;

use App\Rules\MenusRule;
use App\Rules\RolesRule;
use App\Rules\UsersRule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        UsersRule::updateUnique();
        RolesRule::updateUnique();
        MenusRule::menuCheckChild();
    }

}
