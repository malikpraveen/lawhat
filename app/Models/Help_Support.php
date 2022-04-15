<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help_Support extends Model
{
    protected $table = "help_supports";
    protected $fillable = [
        'user_id',
        'email',
        'subject',
        'message',
        'reply',
        'status',
       
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
