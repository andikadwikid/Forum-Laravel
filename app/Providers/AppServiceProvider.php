<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        // $this->registerPolicies();
        // Gate::define('editAndDeleteAnswer', function (User $user, Answer $answer) {
        //     return $answer->user_id == $user->id;
        // });
        Paginator::useBootstrap();
        View::share('answers', Answer::all());
    }
}
