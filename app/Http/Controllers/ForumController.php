<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Forum;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Forum $forum)
    {

        // $forums = Forum::with(['answers', 'users'])->paginate(15);
        // $forums = Forum::when($request->has('title'), function ($query) use ($request) {
        //     $query->where('forum_title', 'like', '%' . $request->title . '%');
        // })->with(['answers', 'users'])->paginate(15);
        $forums = Forum::search($request->title)->with(['answers', 'users'])->latest()->paginate(15);

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
        // dd($request->all());
        $content = $request->forum_content;
        $dom = new \DOMDocument();
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile  = $dom->getElementsByTagName('imageFile ');

        foreach ($imageFile  as $item => $img) {
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $imgData = base64_decode($data);
            $imageName = "/images-forum/" . time() . $item . ".png";
            $path = public_path() . $imageName;
            file_put_contents($path, $imgData);

            $img->removeAttribute('src');
            $img->setAttribute('src', $imageName);
        }
        $slug = Str::slug(request('forum_title'));
        $content = $dom->saveHTML();

        $forum = Forum::create([
            'forum_title' => $request->forum_title,
            'forum_content' => $content,
            'slug' => $slug,
            'user_id' => Auth::user()->id,
        ]);

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
        $forum = Forum::with(['answers', 'users'])->findOrFail($forums->id);
        // $forum = Forum::with(['answers', 'users'])->firstOrFail($forums);
        return view('forum.show-forum', compact('forum', 'forum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
