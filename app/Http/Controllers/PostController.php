<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //
    public function index()
    {
        /* get some posts */
        $posts = Post::latest()->paginate(5);

        /* send $posts to view post blade */
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        /* validate the request */
        $request->validate([
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        /* store the image */
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        /* store the post */
        Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        /* redirect to posts.index */
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show($id)
    {
        /* get one data */
        $post = Post::findOrFail($id);

        /* send $post to view */
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {   
        /* validate the request */
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        /* check if image is uploaded */
        if ($request->hasFile('image')) {
            /* validate the request */
            $request->validate([
                'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            /* store the image */
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            /* update the post */
            Post::findOrFail($id)->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {
            /* update the post */
            Post::findOrFail($id)->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }
       
        /* redirect to posts.index */
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    public function destroy(Post $post){
        /* delete the image */
        Storage::delete('public/posts/' . $post->image);

        /* delete the post */
        $post->delete();

        /* redirect to posts.index */
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
