<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Carbon\Carbon;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, PagerTrait, EloquentJoin, SoftDeletes;


    protected $table = "users";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'azure_id',
        'name',
        'email',
        'avatar',
        'is_partner',
        'is_admin',
        'is_active',
        'department_id',
        'position_id',
        'service_line_id',
        'career_level',
        'has_received_welcome_tokens',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Append the following custom attributes to the model
     */
    protected $appends = [
        'credits',
        'department_name',
        'department_short_name',
        'position_name',
        'service_line_name',
    ];
    
    /**
     * Foreign properties
     **/
    protected $foreignProperties = [
        'position_name' => 'position|positions.name',
        'department_name' => 'department|departments.name',
    ];

    /**
     * Get liked messages by user
     *
     * @return \Illuminate\Support\Collection
     */
    public function messages()
    {
        return $this->belongsToMany(Message::class, 'liked_messages', 'user_id', 'message_id');
    }

    /**
     * Get user department
     *
     * @return Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->withTrashed();
    }

    /**
     * Get user position
     *
     * @return Position
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    /**
     * Get user service line
     *
     * @return ServiceLine
     */
    public function serviceLine()
    {
        return $this->belongsTo(ServiceLine::class, 'service_line_id');
    }

    /**
     * Get the user level of the user
     *
     * @return UserLevel
     */
    public function userLevel()
    {
        return $this->belongsTo(UserLevel::class, 'career_level', 'career_level');
    }

    /**
     * Get the avatar attribute of the model
     *
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if (is_null($value)) {
            return secure_asset("img/default-avatar.png");
        }

        return route('web.photos.get', [
            'filename' => $value,
        ]);
    }

    /**
     * Get the department name of the user
     *
     * @return string
     */
    public function getDepartmentNameAttribute()
    {
        $department = $this->department()->first();

        if (! $department) {
            return null;
        }

        return $department->name;
    }

    /**
     * Get the department name of the user
     *
     * @return string
     */
    public function getDepartmentShortNameAttribute()
    {
        $department = $this->department()->first();

        if (! $department) {
            return null;
        }

        return $department->short_name;
    }

    /**
     * Get the position name of the user
     *
     * @return string
     */
    public function getPositionNameAttribute()
    {
        $position = $this->position()->first();

        if (! $position) {
            return null;
        }

        return $position->name;
    }

    /**
     * Get the name of the service line of the user
     *
     * @return string
     */
    public function getServiceLineNameAttribute()
    {
        $serviceLine = $this->serviceLine()->first();

        if (! $serviceLine) {
            return null;
        }

        return $serviceLine->name;
    }

    /**
     * Get the nearest expiration
     *
     * @return string
     */
    public function getNearestTokenExpirationAttribute()
    {
        $recognizeOthersExpiration = Carbon::now()
            ->addQuarter(1)
            ->firstOfQuarter()
            ->hour(0)
            ->minute(0)
            ->second(0)
            ->toDateTimeString();

        return $recognizeOthersExpiration;
    }

    /////////////////// DEPECRATED ATTRIBUTES ///////////////////

    /**
     * Alias of green_token attribute
     *
     * @return int
     */
    public function getCreditsAttribute()
    {
        return $this->attributes['green_token'];
    }
}
