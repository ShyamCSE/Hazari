<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class wifiLocation extends Model
{
      protected $fillable = ['admin_id', 'ssid', 'location_name', 'mac_address'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
