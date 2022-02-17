<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseLot extends Model
{
    use HasFactory;

    protected $table = "house_lot";

    // protected $fillable = [
    //     'serial_num',
    //     'house_lot_num'
    // ];
    protected $guarded = [];
    
    public function water_readings() {
        return $this->hasMany(WaterMeterReading::class);
    }

    public function branch() {
        return $this->belongsToMany(Branch::class)->withTimeStamps();
    }
}
