<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {
        if (!request()->user()->settings->settings['home_timeline']) {
            return redirect()->route('settings.index');
        }

        return inertia('Home', [
            'posts' => Inertia::scroll(function() {
                return Post::query()
                    ->with('user', 'tags', 'attachments')
                    ->latest()
                    ->paginate();
            })
        ]);
    }
}
