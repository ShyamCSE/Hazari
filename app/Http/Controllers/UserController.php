<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    Public function index(){

      return Inertia::render('Users/index',[
        'users' => User::get(),
      ]);
    }
}
