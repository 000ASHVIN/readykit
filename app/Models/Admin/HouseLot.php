<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseLot extends Model
{
    use HasFactory;

    protected $table = "house_lot";

    protected $fillable = [
        'serial_num',
        'house_lot_num',
        'branch_id'
    ];
    
    public function water_readings() {
        return $this->hasMany(WaterMeterReading::class);
    }

    public function Branch() {
        return $this->belongsTo(Branch::class, 'id', 'branch_id');
    }
}
