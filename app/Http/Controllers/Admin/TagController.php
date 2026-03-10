<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(Request $request) {
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        return inertia('Admin/Tags', [
            'tags' => Inertia::scroll(function () use ($order, $sort) {
                return Tag::query()
                    ->orderBy($sort, $order)
                    ->paginate(50);
            }),
            'filters' => compact('order', 'sort'),
        ]);
    }

    public function destroy(Tag $tag) {
        DB::table('post_tags')->where('tag_id', $tag->id)->delete();
        $tag->delete();
        return back();
    }
}
