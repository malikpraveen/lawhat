<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberPlate extends Model
{
    
    protected $table="number_plates";
    protected $fillable = [

    "logo",
    "logo_name",
    "user_id",
   "plate_number_en",
   "plate_number_ar",
   "plate_alphabets_en",
   "plate_alphabets_ar",
   "price",
   "price_type",
   "calling_country_code",
   "calling_number",
   "calling_number_type",
   "whatsapp_country_code",
   "whatsapp_number",
   "whatsapp_number_type",
   "email",
   "added_by",
   "plate_status",
   "status",
        
    ];

    public function favourite(){
        return $this->hasMany(Favourite::class);
    }

    public function notification(){
        return $this->hasMany(Notification::class);
    }

   
}
