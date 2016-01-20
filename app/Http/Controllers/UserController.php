<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => 'index']);
    }


    public function index()
    {

        $user = Auth::user();

        return view('users.dashboard')->with('user', $user);
    }






    public function show($id)
    {

        $user = User::findOrFail($id);

        return view('users.show')->with('user', $user);
    }


}
