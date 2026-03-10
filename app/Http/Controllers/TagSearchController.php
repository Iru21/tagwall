<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagSearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        return Tag::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->limit(10)
            ->get();
    }
}
