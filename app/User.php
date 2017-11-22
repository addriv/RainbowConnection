<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  public function connections()
  {
    return $this->belongsToMany('App\UserConnection', 'user_connections', 'user_id', 'connected_user_id');
  }
}
