<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
class BlogPostController extends Controller
{
    private function authenticate(Request $request)
    {
        $token = $request->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://identify_service:8080/api/user');  //  URL Identity Service musi sedet s portom aj adresa

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
    public function index()
    {
        return response()->json(BlogPost::all());
    }

    public function show($slug)
    {
        $blogPost = BlogPost::where('slug', $slug)->firstOrFail();
        return response()->json($blogPost);
    }

    public function store(Request $request)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $blogPost = new BlogPost();
        $blogPost->title = $request->title;
        $blogPost->content = $request->content;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog_posts', 'public');
            $blogPost->image = $path;
        }

        $blogPost->save();

        return response()->json($blogPost, 201);
    }

    public function update(Request $request, $id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }


        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $blogPost = BlogPost::findOrFail($id);
        $blogPost->title = $request->title;
        $blogPost->content = $request->content;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog_posts', 'public');
            $blogPost->image = $path;
        }

        $blogPost->save();

        return response()->json($blogPost);
    }



    public function destroy(Request $request,$id)
    {
        $user = $this->authenticate($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }


        $blogPost = BlogPost::findOrFail($id);
        $blogPost->delete();
        return response()->json(['message' => 'Blog post deleted']);
    }
}
