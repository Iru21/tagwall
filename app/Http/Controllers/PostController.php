<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show(Post $post) {
        return inertia('Post/Show', [
            'post' => $post->load('user', 'tags', 'attachments'),
        ]);
    }

    public function create() {
        return inertia('Post/Create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'post_content' => 'required',
            'tags' => 'array',
            'tags.*' => 'string|max:32',
            'attachments' => 'required|array',
            'attachments.*' => 'array',
            'attachments.*.file' => 'required|file|max:10240',
            'attachments.*.is_nsfw' => 'boolean',
            'attachments.*.alt' => 'nullable|string|max:255',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->post_content,
            'user_id' => auth()->id(),
        ]);

        $tags = [];
        foreach ($request->tags as $tag) {
            $tags[] = Tag::firstOrCreate([
                'name' => $tag,
            ]);
        }
        $post->tags()->sync(collect($tags)->pluck('id'));

        $attachments = [];
        foreach ($request->attachments as $attachment) {
            $path = $attachment["file"]->store('attachments', 'public');
            $attachments[] = [
                'path' => $path,
                'is_image' => str_starts_with(Storage::disk('public')->mimeType($path), 'image/'),
                'is_nsfw' => $attachment["is_nsfw"] ?? false,
                'alt' => $attachment["alt"] ?? null,
            ];
        }
        $post->attachments()->createMany($attachments);

        Inertia::flash('success', 'Post created successfully.');

        return to_route('posts.show', $post);
    }
}
