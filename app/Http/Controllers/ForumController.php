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

        $storage = "storage/forum-images";
        $dom = new \DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($request->forum_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];

                $fileNameContent = uniqid();
                $fileNameContentRand = substr(md5($fileNameContent), 6, 6) . '.' . time();
                $filePath = ("$storage/$fileNameContentRand.$mimetype");
                $image = Image::make($src)
                    // ->resize(350, 350)
                    ->encode($mimetype, 100)
                    ->save(public_path($filePath));

                $new_src = asset($filePath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
                $img->setAttribute('class', 'img-fluid');
            }
        }

        // $content = $request->forum_content;
        // $dom = new \DOMDocument();
        // $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        // $imageFile  = $dom->getElementsByTagName('imageFile ');

        // foreach ($imageFile  as $item => $img) {
        //     $data = $img->getAttribute('src');
        //     list($type, $data) = explode(';', $data);
        //     list(, $data)      = explode(',', $data);
        //     $imgData = base64_decode($data);
        //     $imageName = "/images-forum/" . time() . $item . ".png";
        //     $path = public_path() . $imageName;
        //     file_put_contents($path, $imgData);

        //     $img->removeAttribute('src');
        //     $img->setAttribute('src', $imageName);
        // }
        $slug = Str::slug(request('forum_title'));

        try {
            $forum = Forum::create([
                'forum_title' => $request->forum_title,
                // 'forum_content' => $content,
                'forum_content' => $dom->saveHTML(),
                'slug' => $slug,
                'user_id' => Auth::user()->id,
            ]);

            $forum->tags()->sync($request->tags);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while creating forum');
        }

        return redirect()->route('home.index');
        // dd(Auth::user()->id);
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
        // $forum = Forum::with(['answers', 'users'])->firstOrFail($forums);
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

        $storage = "storage/forum-images";
        $dom = new \DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($request->forum_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];

                $fileNameContent = uniqid();
                $fileNameContentRand = substr(md5($fileNameContent), 6, 6) . '.' . time();
                $filePath = ("$storage/$fileNameContentRand.$mimetype");
                $image = Image::make($src)
                    // ->resize(350, 350)
                    ->encode($mimetype, 100)
                    ->save(public_path($filePath));

                $new_src = asset($filePath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
                $img->setAttribute('class', 'img-fluid');
            }
        }

        try {
            $forums->update([
                'forum_title' => $request->forum_title,
                'forum_content' => $dom->saveHTML(),
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

        $storage = "storage/answer-images";
        $dom = new \DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML($request->answer_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];

                $fileNameContent = uniqid();
                $fileNameContentRand = substr(md5($fileNameContent), 6, 6) . '.' . time();
                $filePath = ("$storage/$fileNameContentRand.$mimetype");
                $image = Image::make($src)
                    // ->resize(350, 350)
                    ->encode($mimetype, 100)
                    ->save(public_path($filePath));

                $new_src = asset($filePath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
                $img->setAttribute('class', 'img-fluid');
            }
        }

        try {
            Answer::create([
                'answer_content' => $request->answer_content,
                'user_id' => Auth::user()->id,
                'forum_id' => $forum->id,
            ]);
        } catch (\Exception $e) {
            return $e;
        }
        return redirect()->back();
    }
}
