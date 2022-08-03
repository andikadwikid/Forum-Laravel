<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Forum;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Path\To\DOMDocument;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Forum $forum)
    {
        $forums = Forum::search($request->title)->with(['answers', 'users', 'views'])->latest()->paginate(15);

        return view('home', compact('forums', 'forum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Forum $forums)
    {
        $tags = Tag::get();
        return view('forum.create-forum', compact('forums', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            $image_name = Storage::url('public/forum-images/' . time() . $key . '.png');
            $path = public_path() . $image_name;
            file_put_contents($path, $img_data);

            $image->removeAttribute('src');
            $image->setAttribute('src', $image_name);
            $image->setAttribute('class', 'img-fluid');
        }

        $content = $dom->saveHTML();

        $slug = Str::slug(request('forum_title'));

        try {
            $forum = Forum::create([
                'forum_title' => $request->forum_title,
                'forum_content' => $content,
                // 'forum_content' => $dom->saveHTML(),
                'slug' => $slug,
                'user_id' => Auth::user()->id,
            ]);

            $forum->tags()->sync($request->tags);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while creating forum');
        }

        return redirect()->route('home.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forums)
    {
        $forum = Forum::with(['answers', 'users', 'views', 'tags'])->findOrFail($forums->id);

        $views = [
            'user_id' => Auth::user()->id,
            'forum_id' => $forum->id,
        ];
        $forum->views()->firstOrCreate(['user_id' => $views['user_id']], $views);
        return view('forum.show-forum', compact('forum', 'forum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Forum $forums, Tag $tags)
    {
        $tags = $tags->get();
        return view('forum.edit-forum', compact('forums', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forums)
    {
        $this->authorize('update', $forums);

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
            $image_name = Storage::url('public/forum-images/' . time() . $key . '.png');
            $path = public_path() . $image_name;
            file_put_contents($path, $img_data);

            $image->removeAttribute('src');
            $image->setAttribute('src', $image_name);
            $image->setAttribute('class', 'img-fluid');
        }

        $content = $dom->saveHTML();

        try {
            $forums->update([
                'forum_title' => $request->forum_title,
                'forum_content' => $content,
                'slug' => Str::slug($request->forum_title),
                'user_id' => Auth::user()->id,
            ]);
            $forums->tags()->sync($request->tags);

            return to_route('home.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while updating forum');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forums)
    {
        $this->authorize('delete', $forums);
        try {
            $forums->delete();
            $forums->tags()->detach();
            return to_route('home.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while deleting forum');
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
            $image_name = Storage::url('public/answer-images/' . time() . $key . '.png');
            $path = public_path() . $image_name;
            file_put_contents($path, $img_data);

            $image->removeAttribute('src');
            $image->setAttribute('src', $image_name);
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
