<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'time' => now()->toTimeString(),
            'users' => User::when(request('search'), function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
                ->select('id', 'name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    /* 'can' => [
                        'edit' => Auth::user()->can('edit', $user)
                    ] */
                ]),
            'filters' => request()->only('search'),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }

    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        User::create($validated);

        return redirect('/users');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignoreModel($user)],
            'password' => 'required',
        ]);

        $user->update($validated);

        return redirect('/users');
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect('/users');
    }
}