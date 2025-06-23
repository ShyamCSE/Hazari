<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gpsLocation extends Model
{
   protected $fillable = ['admin_id', 'location_name', 'latitude', 'longitude', 'radius'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
