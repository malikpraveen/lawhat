<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable ;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasApiTokens, Notifiable;
    //
    protected $table = "users";
    protected $fillable = ['user_name','email','country_code','mobile_number','profile_pic','device_token', 'device_type','remember_token','is_otp_verified', 'status'];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

   public function number_plate(){
       return $this->belongsTo(NumberPlate::class,'id','user_id');
   }

   public function notification(){
       return $this->hasMnay(Notification::class);
   }
   
}
