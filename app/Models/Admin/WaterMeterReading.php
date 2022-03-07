<?php

namespace App\Models\Admin;

use App\Models\Core\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;


class WaterMeterReading extends Model
{
    use LaravelVueDatatableTrait;
    use HasFactory;

    protected $table = "water_meter_readings";
    protected $appends = ['usage'];

    public function getUsageAttribute()
    {
        return ($this->current_reading - $this->last_reading);
    }

    public function getImageAttribute($value)
    {
        return asset('storage\images\meter_readings\\' . $value);
    }

    public function getCurrentReadingAttribute($value)
    {
       if(empty($value))
         return 0;
       else
         return $value;  
    }

    public function getLastReadingAttribute($value)
    {
       if(empty($value))
         return 0;
       else
         return $value;  
    }


    protected $casts = [
        'created_at' => 'datetime:Y/m/d h:i:s A',
    ];

    protected $dataTableColumns = [
        'last_reading' => [
            "searchable" => true,
            "orderable" => true,
        ],
        'last_reading' => [
            "searchable" => true,
            "orderable" => true,
        ],
        'usage' => [
            "searchable" => true,
            "orderable" => true,
        ],
        'created_at' => [
            "searchable" => true,
            "orderable" => true,
        ],

    ];


    protected $fillable = [
        'user_id',
        'house_lot_id',
        'branch_id',
        'serial_num',
        'current_reading',
        'last_reading',
        'image',
        'remark'
    ];

    public function branch()
    {
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

    protected $dataTableRelationships = [
        "belongsTo" => [
            "user" => [
                "model" => User::class,
                "foreign_key" => "user_id",
                "columns" => [
                    "first_name" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                ],
            ],
            "house_lot" => [
                "model" => HouseLot::class,
                "foreign_key" => "house_lot_id",
                "columns" => [
                    "house_lot_num" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                    "serial_num" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                ],
            ],
            "branch" => [
                "model" => Branch::class,
                "foreign_key" => "branch_id",
                "columns" => [
                    "name" => [
                        "searchable" => true,
                        "orderable" => true,
                    ],
                ],
            ],
        ],
    ];
}
