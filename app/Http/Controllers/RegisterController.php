<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function index() {
        return inertia('Auth/Register', [
            'accountsRequireApproval' => config('app.accounts_require_approval')
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'min:8|confirmed',
        ]);

        $accounts_require_approval = config('app.accounts_require_approval');

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'activated_at' => $accounts_require_approval ? null : now(),
        ]);

        Inertia::flash('success', 'Account created successfully.' .
            ($accounts_require_approval ?
                ' Until your account is approved, you will not be able to log in.' :
                ' You can now log in.'
            ));

        return to_route('login');
    }
}
