<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'q' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:32',
        ]);

        return inertia('Search', [
            'filters' => [
                'q' => $request->input('q', ''),
                'tags' => $request->input('tags', []),
            ],
            'posts' => Inertia::scroll(function() use ($request) {
                $tags = array_values(array_unique(array_filter((array) $request->input('tags', []))));

                return Post::query()
                    ->when($request->filled('q'), function ($query) use ($request) {
                        $search = $request->string('q')->toString();
                        $query->where(function ($query) use ($search) {
                            $query->where('title', 'like', "%{$search}%")
                                ->orWhere('content', 'like', "%{$search}%");
                        });
                    })
                    ->when(count($tags) > 0, function ($query) use ($tags) {
                        foreach ($tags as $tag) {
                            $query->whereHas('tags', function ($query) use ($tag) {
                                $query->where('name', $tag);
                            });
                        }
                    })
                    ->with('user', 'tags', 'attachments')
                    ->latest()
                    ->paginate();
            })
        ]);
    }
}
