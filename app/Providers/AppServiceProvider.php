<?php

namespace App\Providers;

use App\Models\Answer;
use App\Models\Forum;
use App\Models\User;
use Carbon\Carbon;
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
        Paginator::useBootstrap();
        View::share(
            'popular_forum',
            Forum::withCount('views')
                ->orderBy('views_count', 'desc')
                ->limit(10)
                ->get()
        );
        View::share(
            'popular_today_forum',
            Forum::withCount('views')
                ->orderBy('views_count', 'desc')
                ->whereDate('created_at', Carbon::today())
                ->limit(5)
                ->get()
        );
        View::share(
            'recent_forum',
            Forum::orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
        );
    }
}
