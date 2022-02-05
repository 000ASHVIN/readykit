<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseLot extends Model
{
    protected $table =  "house_lot";
    protected $fillable = [
        'serial_num',
        'house_lot_num'
    ];
    use HasFactory;
    public function water_readings()
    {
        return $this->hasMany(WaterMeterReading::class);
    }
}
