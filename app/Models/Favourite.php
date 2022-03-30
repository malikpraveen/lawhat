<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = "favourites";
    protected $fillable = [
        "user_id",
        "plate_id",
        "status",
    ];


    public function plates()
    {
        return $this->belongsTo(NumberPlate::class,'plate_id','id')->where('status','enable');
    }
}
