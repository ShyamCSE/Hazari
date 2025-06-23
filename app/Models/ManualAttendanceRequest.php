<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualAttendanceRequest extends Model
{
   protected $fillable = ['user_id', 'date', 'punch_time', 'type', 'reason', 'status', 'reviewed_by', 'reviewed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
