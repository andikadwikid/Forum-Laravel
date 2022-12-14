<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Forum;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class ForumController extends Controller
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

    public function index(Request $request, Forum $forum)
    {
        $forums = Forum::search($request->title)->with(['answers', 'users', 'views'])->latest()->paginate(15);

        return view('home', compact('forums', 'forum'));
    }


    public function create(Forum $forums)
    {
        $tags = Tag::get();
        return view('forum.create-forum', compact('forums', 'tags'));
    }


    public function store(Request $request)
    {

        $dom = new \DomDocument();
        $dom->loadHtml($request->forum_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $image_file = $dom->getElementsByTagName('img');

        if (!File::exists(public_path('storage/forum-images'))) {
            File::makeDirectory(public_path('storage/forum-images'));
        }
        foreach ($image_file as $key => $image) {
            $data = $image->getAttribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);

            $img_data = base64_decode($data);

            //nama image
            $image_name = time() . $key . '.png';

            $url_image = Storage::url('public/forum-images/' . time() . $key . '.png');
            $path = public_path() . Storage::url('public/forum-images/' . time() . $key . '.png');
            file_put_contents($path, $img_data);

            $image->removeAttribute('src');
            $image->setAttribute('src', $url_image);
            $image->setAttribute('class', 'img-fluid');
        }

        $content = $dom->saveHTML();

        $slug = Str::slug(request('forum_title'));

        try {
            $forum = Forum::create([
                'forum_title' => $request->forum_title,
                'forum_content' => $content,
                'slug' => $slug,
                'user_id' => Auth::user()->id,
            ]);

            $forum->tags()->sync($request->tags);
            return to_route('home.show', $slug)->with('success', 'Task Created Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while creating question');
        }

        return redirect()->route('home.index');
    }


    public function show(Forum $forums)
    {
        $forum = Forum::with(['answers', 'users', 'views', 'tags'])->findOrFail($forums->id);

        if (Auth::check()) {
            $views = [
                'user_id' => Auth::user()->id,
                'forum_id' => $forum->id,
            ];
            $forum->views()->firstOrCreate(['user_id' => $views['user_id']], $views);
        }
        return view('forum.show-forum', compact('forum', 'forum'));
    }


    public function edit(Forum $forums, Tag $tags)
    {
        $tags = $tags->get();
        return view('forum.edit-forum', compact('forums', 'tags'));
    }


    public function update(Request $request, Forum $forums)
    {
        $this->authorize('update', $forums);

        $dom = new \DomDocument();
        $dom->loadHtml($request->forum_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $image_file = $dom->getElementsByTagName('img');
        $bs64 = 'base64';

        if (!File::exists(public_path('storage/forum-images'))) {
            File::makeDirectory(public_path('storage/forum-images'));
        }

        foreach ($image_file as $key => $image) {
            $data = $image->getAttribute('src');
            if (strpos($data, $bs64) == true) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                $img_data = base64_decode($data);

                //nama image
                $image_name = time() . $key . '.png';

                $url_image = Storage::url('public/forum-images/' . time() . $key . '.png');
                $path = public_path() . $url_image;
                file_put_contents($path, $img_data);

                $image->removeAttribute('src');
                $image->setAttribute('src', $url_image);
                $image->setAttribute('class', 'img-fluid');
            } else {
                $image->setAttribute('class', 'img-fluid');
            }
        }

        $content = $dom->saveHTML();
        $slug = Str::slug($request->forum_title);
        try {
            $forums->update([
                'forum_title' => $request->forum_title,
                'forum_content' => $content,
                'slug' => $slug,
                'user_id' => Auth::user()->id,
            ]);
            $forums->tags()->sync($request->tags);

            return to_route('home.show', $slug)->with('success', 'Question Modified Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while updating question');
        }
    }


    public function destroy(Forum $forums)
    {
        $this->authorize('delete', $forums);
        try {
            $forums->delete();
            $forums->tags()->detach();
            return to_route('home.index')->with('success', 'Question Successfully Removed!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while deleting question');
        }
    }

    public function answerStore(Request $request, Forum $forum)
    {

        $dom = new \DomDocument();
        $dom->loadHtml($request->answer_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $image_file = $dom->getElementsByTagName('img');

        if (!File::exists(public_path('storage/answer-images'))) {
            File::makeDirectory(public_path('storage/answer-images'));
        }
        foreach ($image_file as $key => $image) {
            $data = $image->getAttribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);

            $img_data = base64_decode($data);

            //nama image
            $image_name = time() . $key . '.png';

            $url_image = Storage::url('public/answer-images/' . time() . $key . '.png');
            $path = public_path() . $url_image;
            file_put_contents($path, $img_data);

            $image->removeAttribute('src');
            $image->setAttribute('src', $url_image);
            $image->setAttribute('class', 'img-fluid');
        }

        $content = $dom->saveHTML();

        try {
            Answer::create([
                'answer_content' => $content,
                'user_id' => Auth::user()->id,
                'forum_id' => $forum->id,
            ]);
        } catch (\Exception $e) {
            return $e;
        }
        return redirect()->back();
    }
}
