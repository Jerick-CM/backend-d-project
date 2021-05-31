<?php

namespace App\Models;

use App\Traits\PagerTrait;
use Carbon\Carbon;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use PagerTrait, EloquentJoin, SoftDeletes;
    
    protected $table = "messages";
    // Primary Key
    public $primarykey = "id";
    // Timestamps 
    public $timestamps = true;

    /**
     * Fields that can be mass assigned
     */
    protected $fillable = [
        'sender_user_id',
        'recipient_user_id',
        'message',
        'message_badge_id',
        'message_token_id',
    ];
    
    /**
     * Append the following relationships to the model
     *
     * @var array
     */
    protected $with = [
        'sender',
        'recipient',
    ];

    /**
     * Append the following custom attributes to the model
     *
     * @var array
     */
    protected $appends = [
        'is_liked_by_user',
        'total_likes',
        'green_tokens',
        'badge',
        'badge_id',
        ///////////////// DEPECRATED ATTRIBUTES /////////////////
        'from_user_id',
        'to_user_id',
        'credits',
        'token_expiration',
    ];

    protected $foreignProperties = [
        'credits' => 'messageToken|message_tokens.amount',
        'sender_name' => 'sender|users.name',
        'recipient_name' => 'recipient|users.name',
        'badge_name' => 'messageBadge|messageBadge.badge|badges.name',
        'sender_department_name' => 'sender|sender.department|departments.name',
        'recipient_department_name' => 'recipient|recipient.department|departments.name',
    ];

    /**
     * Get user data of sender
     *
     * @return User
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id')->withTrashed();
    }

    /**
     * Get user data of recipient
     *
     * @return User
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id')->withTrashed();
    }

    /**
     * Get the model of the badge that was sent
     *
     * @return MessageBadge
     */
    public function messageBadge()
    {
        return $this->belongsTo(MessageBadge::class)->withTrashed();
    }

    /**
     * Get the model of the token that was sent
     *
     * @return MessageToken
     */
    public function messageToken()
    {
        return $this->belongsTo(MessageToken::class)->withTrashed();
    }

    /**
     * Get liked nominations by user
     *
     * @return \Illuminate\Support\Collection
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'liked_messages', 'message_id', 'user_id')->withTrashed();
    }

    /**
     * Replace new lines with br
     *
     * @param string $value
     * @return string
     */
    public function getMessageAttribute($value)
    {
        return nl2br($value);
    }

    /**
     * Apply nl2br on message before saving
     *
     * @param string $value
     * @return void
     */
    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = preg_replace("/[\r\n]{2,}/", "\n\n", $value);
    }

    ///////////////// CUSTOM ATTRIBUTES /////////////////

    /**
     * Check if nomination is liked by user
     *
     * @return bool
     */
    public function getIsLikedByUserAttribute()
    {
        $user_id = auth()->user()->id;

        $exists = LikedMessage::where([
                'user_id' => $user_id,
                'message_id' => $this->attributes['id'],
            ])
            ->count();
        
        if (! $exists) {
            return false;
        }

        return true;
    }

    /**
     * Count total number of likes of the message
     *
     * @return int
     */
    public function getTotalLikesAttribute()
    {
        return LikedMessage::where('message_id', $this->attributes['id'])->count();
    }

    /**
     * Get the amount of green token sent for this message
     *
     * @return int
     */
    public function getGreenTokensAttribute()
    {
        return $this->messageToken()->first()->amount;
    }

    /**
     * Get badge model sent for this message
     *
     * @return Badge
     */
    public function getBadgeAttribute()
    {
        return $this->messageBadge()->first()->badge;
    }

    /**
     * Get the id of the badge sent for this message
     *
     * @return int
     */
    public function getBadgeIdAttribute()
    {
        return $this->messageBadge()->first()->type;
    }

    /**
     * Get token expiration if applicable
     *
     * @return string
     */
    public function getTokenExpirationAttribute()
    {
        $messageToken = $this->messageToken()->first();
        
        if (! $messageToken || ! $messageToken->amount) {
            return 'N/A';
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $messageToken->expires_at)->toDateString();
    }

    ///////////////// DEPECRATED ATTRIBUTES /////////////////

    /**
     * Alias for sender_user_id attribute
     *
     * @return int
     */
    public function getFromUserIdAttribute()
    {
        return $this->attributes['sender_user_id'];
    }

    /**
     * Alias for recipient_user_id attribute
     *
     * @return int
     */
    public function getToUserIdAttribute()
    {
        return $this->attributes['recipient_user_id'];
    }

    /**
     * Alias for green token
     *
     * @return int
     */
    public function getCreditsAttribute()
    {
        return $this->getGreenTokensAttribute();
    }
}
