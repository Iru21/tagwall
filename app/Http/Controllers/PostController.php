<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create() {
        return inertia('Post/Create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'tags' => 'array',
            'tags.*' => 'string|max:32',
            'attachments' => 'required|array',
            'attachments.*' => 'file',
        ]);
    }
}
