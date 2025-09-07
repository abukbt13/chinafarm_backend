<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class BlogController extends Controller
{
    public function ShowBlogs()
    {
        $user_id = Auth::id(); // shortcut to get logged-in user id

        $blogs = Blog::where('user_id', $user_id)
            ->latest()
            ->take(5) // get only 5
            ->get();

        return response()->json([
            'status' => 'success',
            'blogs'  => $blogs,
        ]);
    }
    public function ShowBlog($hashid)
    {

        $id = Hashids::decode($hashid)[0] ?? null;
        if (!$id) {
            abort(404);
        }

        $blog = Blog::findOrFail($id);
        return response()->json($blog);

    }

    public function storeBlogs(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        return Blog::create($validated);
    }


    public function UpdateBlogs(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return $blog;
    }

    public function DestroyBlog(Blog $blog)
    {
        $this->authorize('delete', $blog);

        $blog->delete();
        return response()->json(['message' => 'Blog deleted']);
    }
}
