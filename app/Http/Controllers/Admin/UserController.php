<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');
        return inertia('Admin/Users', [
            'users' => Inertia::scroll(function () use ($search, $sort, $order) {
                return User::query()
                    ->when($search, function ($query) use ($search) {
                        $query->where('username', 'like', "%$search%")
                            ->orWhere('id', 'like', "%$search%");
                    })
                    ->orderBy($sort, $order)
                    ->paginate(20);
            }),
            'filters' => compact('search', 'sort', 'order'),
        ]);
    }

    public function activate(User $user) {
        $user->update(['activated_at' => now()]);
        return back();
    }

    public function deactivate(User $user) {
        if($user->is_admin) {
            return back()->withErrors(['error' => 'Cannot deactivate admin user']);
        }

        $user->update(['activated_at' => null]);
        return back();
    }

    public function destroy(User $user) {
        if($user->is_admin) {
            return back()->withErrors(['error' => 'Cannot delete admin user']);
        }

        $user->delete();
        return back();
    }
}
