<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimePeriod extends Model
{
      protected $table = "time_periods";
      protected $fillable = ['notification_id','first_time_period','grace_period'];
}
