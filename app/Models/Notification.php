<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notifications";
    protected $fillable = [
        'user_id',
        'plate_id',
        'title_en',
        'title_ar',
        'body_en',
        'body_ar',
        'read',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plate(){
        return $this->belongsTo(NumberPlate::class);
    }

    public function user_detail(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
