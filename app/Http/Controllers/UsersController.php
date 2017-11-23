<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
  public function index(){
    $users = User::with('connectedUsers')->paginate(25);

    $formattedData = [];
    foreach ($users as &$value){
      $data = [
        'id' => $value['id'],
        'type' => 'user',
        'attributes' => [
          'first_name' => $value['first_name'],
          'last_name' => $value['last_name'],
          'favorite_color' => $value['favorite_color'],
          'connected_users' => $value['connectedUsers']
        ]
      ];

      array_push($formattedData, $data);
    }
    return [ 
      'data' => $formattedData,
      'meta' => [ 'total_pages' => 4 ] 
    ];
  }

  public function show($userId){
    $user = User::find($userId); 

    $formattedData = [
      'id' => $user['id'],
      'type' => 'user',
      'attributes' => [
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'favorite_color' => $user['favorite_color'],
        'connected_users' => $user->connectedUsers()->get()
      ]
    ];
    
    if ($user) {
      return [
        'data' => $formattedData,
        'meta' => [ 'total_pages' => 2]
      ];
    } else {
      return "Error: No user found";
    }
  }
}
