<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
  public function index(){
    $users = User::with('connectedUsers')->get();
    return $users;
  }

  public function show($userId){
    $user = User::find($userId); 
    if ($user) {
      return [
        'user' => $user,
        'connections' => $user->connectedUsers()->get()
      ];
    } else {
      return "Error: No user found";
    }
  }
}
