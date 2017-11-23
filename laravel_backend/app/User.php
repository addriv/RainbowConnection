<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  public function connections()
  {
    return $this->hasMany('App\UserConnection', 'user_id', 'id');
  }

  public function connectedUsers()
  {
    return $this->hasManyThrough(
      'App\User', 
      'App\UserConnection', 
      'connected_user_id',
      'id',
      'id',
      'user_id'
    );
  }
}
