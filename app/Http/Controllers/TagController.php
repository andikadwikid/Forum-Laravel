<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Tag $tags)
    {
        $forums = $tags->forums()->latest()->paginate(15);
        return view('home', compact('forums', 'tags'));
    }
}
