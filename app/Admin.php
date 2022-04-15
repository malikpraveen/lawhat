<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable 
{
    use HasApiTokens;
    protected $table='admin';
    protected $fillable = [
    	'name',
    	'email',
    	'password'
   	];

   	protected $hidden =[
		'password', 'remember_token'
	];
	
	public $timestamps = true;
}
