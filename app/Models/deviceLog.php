<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class deviceLog extends Model
{
      protected $fillable = ['user_id', 'device_name', 'platform', 'browser', 'ip_address', 'last_login_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
