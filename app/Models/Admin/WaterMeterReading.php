<?php

namespace App\Models\Admin;

use App\Models\Core\Auth\User;
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

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function house_lot()
    {
        return $this->belongsTo(HouseLot::class, 'house_lot_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
