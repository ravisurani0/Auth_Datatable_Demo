<?php

namespace App\Http\Admin;


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\Datatables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div><a href="/users/' . $row->id . '" class="btn btn-primary btn-sm mr-2">
                    <i class="fas fa-pencil-alt icon-md"></i> Details</a>
                    <a href="/remove-user/' . $row->id . '" class="btn btn-danger btn-sm mr-2" onclick="return confirm("Are you sure?")">
                    <i class="fas fa-pencil-alt icon-md"></i> Remove</a> </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('layouts.user.index');
    }

    public function create()
    {
        $data = [
            "user" => null,
        ];
        return view('layouts.user.form')->with($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'new_password' => 'nullable|min:8|max:12',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);


        User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
        ]);

        return redirect(route('users.index'))->with('msg', 'New User Created successful!');
    }

    public function show(User $user)
    {
        return view('layouts.user.form', compact('user'));
    }

    public function edit(User $user)
    {
        $data = [
            "user" => $user,
        ];

        return view('layouts.user.form')->with($data);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            "name" => "required",
            "address" => "nullable",
            "last_name" => "nullable",
            "email" => "nullable",
            "role" => "nullable",
            "password" => "nullable",
        ]);

        $user->update($validated);
        $msg = "User Updated successful! ";
        return redirect(route('users.index'))->with('msg', $msg);
    }

    public function destroy(User $user)
    {
        $user->delete();
        $msg = "User Deleted successful! ";

        return redirect(route('users.index'))->with('msg', $msg);

    }
}
