<?php

namespace Modules\Blog\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 6);
        return Post::with('user:id,name')->latest()->paginate($perPage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:3',
            'body' => 'required|min:3',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tag' => 'required|string|max:100',
        ]);

        if ($request->hasFile('feature_image')) {
            $file = $request->file('feature_image');
            $filename = time() . '-' . $file->getClientOriginalName(); // unique filename
            $file->move(public_path('posts'), $filename); // move to public/posts
            $validatedData['feature_image'] = secure_url("posts/{$filename}"); // store full URL
        }

        $validatedData['user_id'] = auth()->id(); // You can replace this with auth()->id() if using auth

        return Post::create($validatedData);
    }

    /**
     * Show the specified resource.
     */
    public function show(Post $post)
    {
        return $post->load('user:id,name');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return $post->load('user:id,name');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        // Define validation rules
        $rules = [
            'title' => 'required|min:3',
            'body' => 'required|min:3',
            'feature_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // Manually validate to avoid Laravel's PATCH + FormData issues
        $validator = \Validator::make(
            $request->all() + $request->only(['title', 'body']),
            $rules
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        // Handle new image upload
        if ($request->hasFile('feature_image')) {
            $validatedData['feature_image'] = $request->file('feature_image')->store('posts', 'public');

            // Optional: delete old image if needed
            // Storage::delete('public/' . $post->feature_image);
        }

        // Update post
        $post->update($validatedData);

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
    }
}
