<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = "area";
    protected $fillable = [
        'name'
    ];

    public function branches(){
        return $this->hasMany(Branch::class,'area_id','id');
    }
}
