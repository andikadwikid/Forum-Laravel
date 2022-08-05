<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TagController extends Controller
{
    public function __construct()
    {
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

    public function show(Tag $tags)
    {
        $forums = $tags->forums()->latest()->paginate(15);
        return view('home', compact('forums', 'tags'));
    }
}
