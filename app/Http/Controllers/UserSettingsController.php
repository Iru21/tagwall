<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserSettingsController extends Controller
{
    public function index(Request $request) {
        if($request->wantsJson()) {
            return $request->user()->settings->settings;
        }

        return inertia('UserSettings');
    }

    public function update(Request $request) {
        $request->user()->settings()->update(['settings' => json_encode($request->all())]);
        if($request->wantsJson()) {
            return $request->user()->settings->settings;
        }
        return back();
    }
}
