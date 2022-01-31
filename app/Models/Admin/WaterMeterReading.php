<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterMeterReading extends Model
{
    use HasFactory;

    protected $table= "water_meter_readings";

    protected $fillable  = [
        'user_id',
        'house_lot_id',
        'branch_id',
        'serial_num',
        'current_reading',
        'last_reading',
        'image',
        'remark'
    ];
}
