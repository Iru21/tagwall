<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {
        return inertia('Home', [
            'posts' => Inertia::scroll(function($page) {
                return Post::query()
                    ->with('user', 'tags', 'attachments')
                    ->latest()
                    ->paginate(10, ['*'], 'page', $page);
            })
        ]);
    }
}
