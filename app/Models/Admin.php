<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Model
{
    use HasApiTokens;
    protected $table='admin';
    protected $fillable = [
    	'name',
    	'email',
    	'password',
		'otp',
        'type'
   	];

   	protected $hidden =[
		'password', 'remember_token'
	];
	
	public $timestamps = true;
}
