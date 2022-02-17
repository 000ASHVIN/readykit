<?php

namespace App\Models\Admin;

use App\Models\Core\Auth\User;
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

    public function houseLot() {
        return $this->belongsToMany(HouseLot::class)->withTimeStamps();
    }

    public function users() {
        return $this->hasMany(User::class, 'branch_id', 'id');
    }
}
