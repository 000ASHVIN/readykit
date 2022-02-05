<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table= "branch";
    protected $fillable = [
        'name'
    ];

    public function water_readings(){
        return $this->hasMany(WaterMeterReading::class);
    }
}
