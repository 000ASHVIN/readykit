<?php

namespace App\Models\Core\Auth;

use Altek\Eventually\Eventually;
use App\Models\Admin\Branch;
use App\Models\Core\Auth\Traits\Attribute\UserAttribute;
use App\Models\Core\Auth\Traits\Boot\UserBootTrait;
use App\Models\Core\Auth\Traits\Method\HasRoles;
use App\Models\Core\Auth\Traits\Method\UserMethod;
use App\Models\Core\Auth\Traits\Method\UserStatus;
use App\Models\Core\Auth\Traits\Relationship\UserRelationship;
use App\Models\Core\Auth\Traits\Rules\UserRules;
use App\Models\Core\Auth\Traits\Scope\UserScope;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Admin\WaterMeterReading;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;


class User extends BaseUser implements HasLocalePreference
{
    use LaravelVueDatatableTrait;

    protected static $logAttributes = [
        'first_name', 'last_name', 'email'
    ];

    protected $dataTableColumns = [
        'first_name' => [
            'searchable' => true,
            'sortable'   => true
        ],
        'last_name' => [
            'searchable' => true,
            'sortable'   => true
        ],
        'serial_num' => [
            'searchable' => true,
        ],

    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'temp_password',
        'branch_id',
        'created_by',
        'status_id',
        'invitation_token',
        'remember_token',
        'last_login_at'
    ];

    use UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        HasRoles,
        UserRules,
        UserBootTrait,
        LogsActivity,
        Eventually,
        Notifiable,
        CausesActivity,
        UserStatus;

    public function water_readings()
    {
        return $this->hasMany(WaterMeterReading::class);
    }

    public function preferredLocale()
    {
        return app()->getLocale() ?? 'en';
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $class_alias_array = explode('\\', get_called_class());
        $class_name = strtolower(end($class_alias_array));

        return trans('default.log_description_message', [
            'model' => trans('default.' . $class_name),
            'event' => trans('default.' . $eventName)
        ]);
    }

    public function branch() {
        return $this->hasOne(Branch::class, "id", "branch_id");
    }
}
