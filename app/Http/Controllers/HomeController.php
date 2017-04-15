<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;
use App\User;
class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(User $user)
    {
    	
        return view('users.show', compact('user'));
    }
}
