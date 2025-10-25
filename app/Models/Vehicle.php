<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Vehicle extends Model
{
    protected $fillable=[
        "company_id",
"model_id",
"year",
"category_id",
"price",
"mileage",
"body_id",
"fuel_id",
"color_id",
"gearbox_id",
"condition_id",
"user_id",
"payment",
"location",
"description",
"engineSize_id",
"engineType_id",
"available"
    ];
    public function user(){
      return $this->belongsTo(User::class);
    }
    public function body(){
       return $this->belongsTo(BodyType::class);
    }
        public function model(){
       return $this->belongsTo(CarModel::class);
    }
        public function category(){
       return $this->belongsTo(Category::class);
    }
     public function color (){
       return $this->belongsTo(Color::class);
    }
     public function company(){
       return $this->belongsTo(Company::class);
    }
     public function fuel(){
       return $this->belongsTo(FuelType::class);
    }
     public function gearbox(){
       return $this->belongsTo(Gearbox::class);
    }
     public function condition(){
       return $this->belongsTo(Condition::class);
    }
    public function engineType(){
      return $this->belongsTo(EngineType::class,"engineType_id","id");
    }
    public function engineSize(){
      return $this->belongsTo(EngineSize::class,"engineSize_id","id");
    }
     public function images(){
      return $this->hasMany(Vehicle_image::class);
    }
        public function ad() {
        return $this->hasOne(Ad::class);
    }
}


