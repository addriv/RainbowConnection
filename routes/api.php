<?php

use Illuminate\Http\Request;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/users', function (Request $request) {
//     return $request->user();
// });

Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'update']]);

// Route::get('/users/{id?}', function($id = null){
//   // return $id;
//   if ($id == null){
//     return User::all();
//   } else {
//     return User::find($id);
//   }
// });

// Route::get('/test', function(){
//   return User::find(1)->connectedUsers()->get();
// });
