<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{

    /**
     * Display view to create a new user
     * @return \Illuminate\View\View
     */
    public function create(){
        return view('users.create', ['users' => User::all()]);
    }
    /**
     * Create a new user
     * @param  App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request){
        User::create(['name' => $request->name,'email' => $request->email,'password' => Hash::make($request->password)]);
        return redirect()->back()->with('success', 'Votre utilisateur à bien été créer !');
    }
}
