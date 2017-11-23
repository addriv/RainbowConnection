<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Artisan;
use App\User;
use App\UserConnection;
use Faker\Factory as Faker; // Faker for generating random names

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

  public function test(Request $request){
    // Clear database
    DB::statement('TRUNCATE users, user_connections RESTART IDENTITY;');
    
    $userCount = intval($request['userCount']);

    function generateUsers($count)
    {
      // use the factory to create a Faker\Generator instance
      $faker = Faker::create();

      // Favorite color choices
      $colors = [
        // Primary
        'red',
        'yellow',
        'blue',
        // Secondary
        'green',
        'orange',
        'violet',
        // Tertiary
        'red-orange',
        'red-violet',
        'yellow-orange', 
        'yellow-green', 
        'blue-green', 
        'blue-violet', 
      ];

      for ($i=0; $i < $count; $i++){
        $user = new User;
        $user->first_name = $faker->firstName;
        $user->last_name = $faker->lastName;
        $user->favorite_color = $colors[rand(0,11)];
        $user->save();
      }
    }

    function generateConnections($count)
    {
      // Assign random connection count between 0-50 for each user
      $connectionCounts = [];
      for ($i=0; $i < $count; $i++) {
        array_push($connectionCounts, rand(0, 50));
      }

      // Get additional connections needed for user
      function additionalConnectionCount($userId, $connectionCounts){
        // Get all connections for user
        $currentConnections = DB::table('user_connections')
          ->where('user_id', $userId)
          ->get();
        $currentCount = count($currentConnections);
        return $connectionCounts[$userId - 1] - $currentCount;
      }

      // Find if connection is valid between two user ids
      function isConnectedIdValid($currentUserId, $connectedId, $connectionCounts){
        // Not valid if ids are the same
        if ($currentUserId == $connectedId){
          return false;
        }

        // Find if current user is already connected to connected user id
        $connectedRows = DB::table('user_connections')
          ->where('user_id', $currentUserId)
          ->where('connected_user_id', $connectedId)
          ->get();
        $connectedCount = count($connectedRows);
        
        // Not valid if users are already connected or the connected user id already has full connections
        if ($connectedCount >= 1 || additionalConnectionCount($connectedId, $connectionCounts) <= 0) {
          return false;
        } else {
          return true;
        }
      }

      // Generate user_connections records
      for ($i=1; $i <= $count; $i++){
        // Add remaining connections needed for each user
        for ($j=0; $j < additionalConnectionCount($i, $connectionCounts); $j++){
          // Generate random connected user id until the connection is valid between each user
          $connectedId = rand(1, $count);
          while (!isConnectedIdValid($i, $connectedId, $connectionCounts)){
            $connectedId = rand(1, $count);
          }

          // Insert connection records
          $userConnection = new UserConnection;
          $userConnection->user_id = $i;
          $userConnection->connected_user_id = $connectedId;
          $userConnection->save();

          $inverseConnection = new UserConnection;
          $inverseConnection->user_id = $connectedId;
          $inverseConnection->connected_user_id = $i;
          $inverseConnection->save();
        }
      }
    }
    
    generateUsers($userCount);
    generateConnections($userCount);
  }
}
