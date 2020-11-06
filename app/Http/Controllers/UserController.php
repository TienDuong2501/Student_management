<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(10);

        return view('user.index')->with(['users' => $users, 'authUser' => auth()->user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role == 1) {
            return view('user.create');
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        if (auth()->user()->role == 1) {
            $user = User::create([
                'name' => $request->name,
                'fullname' => $request->fullname,
                'phone' => $request->phone,
                'role' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($user) {
                return redirect()->route('users.index')->with(['success' => 'created user successfully']);
            }

            return redirect()->route('users.index')->with(['error' => 'created user failed']);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show')->with(['user' => $user, 'authUser' => auth()->user()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (auth()->user()->role == 1 || $user->id == auth()->user()->id) {
            return view('user.edit')->with(['user' => $user, 'authUser' => auth()->user()]);
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if (auth()->user()->role == 1)
        {
            $user->name = $request->name;
            $user->fullname = $request->fullname;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->save();
            if ($user) {
                return redirect()->route('users.index')->with(['success' => 'updated user successfully']);
            }

            return redirect()->route('users.index')->with(['error' => 'updated user failed']);
        } else if ($user->id == auth()->user()->id) {
            $user->phone = $request->phone;
            $user->email = $request->email;
            if ($request->password != $user->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            if ($user) {
                return redirect()->route('users.index')->with(['success' => 'updated user successfully']);
            }

            return redirect()->route('users.index')->with(['error' => 'updated user failed']);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->role == 1) {
            if ($user->delete()) {
                return redirect()->route('users.index')->with(['success' => 'deleted user successfully']);
            }

            return redirect()->route('users.index')->with(['error' => 'deleted user failed']);
        }

        return redirect()->back();
    }
}
