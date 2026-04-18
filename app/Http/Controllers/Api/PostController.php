<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ✅ 'with' use karne se "N+1 Problem" solve ho jati hai
        $posts = Post::with('category')->latest()->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        // Image handling
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => $request->user()->id, // ✅ Token se user ID mil jayegi
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . rand(100, 999),
            'content' => $validated['content'],
            'image' => $imagePath,
            'status' => $validated['status'] ?? 'published',
        ]);

        return response()->json([
            'message' => 'Post created successfully!',
            'data' => new PostResource($post) // Naya post clean format mein wapas bhej diya
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Eager load category and author for detail view
        $post->load(['category', 'author']);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        // 1. Image Handling (Agar nayi image aayi hai)
        if ($request->hasFile('image')) {
            // Purani image delete karein
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Nayi image store karein
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        // 2. Slug update (Optional: agar title badla hai)
        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);

        // 3. Update Database
        $post->update($validated);

        return response()->json([
            'message' => 'Post updated successfully!',
            'data' => new PostResource($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        // Authorization check
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Aap dusre ki post delete nahi kar sakte!'], 403);
        }

        // Database se record delete karein
        $post->delete();

        return response()->json(['message' => 'Post delete kar di gayi hai.']);
    }
}
