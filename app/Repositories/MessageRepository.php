<?php

namespace App\Repositories;

use App\Events\BlackTokenLogEvent;
use App\Events\GreenTokenLogEvent;
use App\Models\BlackTokenLog;
use App\Models\GreenTokenLog;
use App\Models\Message;
use App\Models\MessageBadge;
use App\Models\MessageToken;
use App\Models\User;
use Takaworx\Brix\Traits\RepositoryTrait;

class MessageRepository extends Message
{
    use RepositoryTrait;

    /**
     * DB table to be used for this repo
     *
     * @var string
     */
    protected $table = 'messages';

    public function sendMessage($sender_user_id, $recipient_user_id, $badge_id, $token_amount, $message)
    {
   
        // Decrement black token of sender
        $this->logBlackToken($sender_user_id, $token_amount);

        // Save message badge
        $messageBadge = $this->createMessageBadge($sender_user_id, $recipient_user_id, $badge_id);

        // Save message token
        $messageToken = $this->createMessageToken($sender_user_id, $recipient_user_id, $token_amount);

        // Save message
        $message = $this->createMessage($sender_user_id, $recipient_user_id, $message, $messageBadge, $messageToken);
        
        // Increment green token of recipient
        $amount = $messageToken->amount;
        $badge_name = $messageBadge->badge->name;
        $expires_at = $messageToken->expires_at;
        $this->logMessageToken($recipient_user_id, $amount, $sender_user_id, $badge_name, $expires_at);

        return $message;
    }

    /**
     * Create a like record of this message and given user in pivot table
     *
     * @param int $message_id
     * @param int $user_id
     */
    public function like($message_id, $user_id)
    {
        $message = $this->find($message_id);

        if ($message->is_liked_by_user) {
            $message->users()->detach($user_id);
        } else {
            $message->users()->attach($user_id);
        }

        return true;
    }

    //////////////// PROTECTED METHODS ////////////////

    protected function createMessageBadge($sender_user_id, $recipient_user_id, $badge_id)
    {
        $messageBadge = MessageBadge::create([
            'sender_user_id'    => $sender_user_id,
            'recipient_user_id' => $recipient_user_id,
            'type' => $badge_id,
        ]);

        return $messageBadge;
    }

    protected function createMessageToken($sender_user_id, $recipient_user_id, $token_amount)
    {
        $messageToken = MessageToken::create([
            'sender_user_id'    => $sender_user_id,
            'recipient_user_id' => $recipient_user_id,
            'amount' => $token_amount,
        ]);

        return $messageToken;
    }

    protected function createMessage($sender_user_id, $recipient_user_id, $message, $messageBadge, $messageToken)
    {
        $message = Message::create([
            'sender_user_id'    => $sender_user_id,
            'recipient_user_id' => $recipient_user_id,
            'message_badge_id' => $messageBadge->id,
            'message_token_id' => $messageToken->id,
            'message'  => $message,
        ]);

        return $message;
    }

    protected function logMessageToken($recipient_user_id, $amount, $sender_user_id, $badge_name, $expires_at)
    {
        event(new GreenTokenLogEvent(
            $recipient_user_id,
            GreenTokenLog::ACTION_CREDIT,
            GreenTokenLog::TYPE_NOMINATION,
            $amount,
            $badge_name,
            $sender_user_id,
            $expires_at
        ));
    }

    protected function logBlackToken($sender_user_id, $token_amount)
    {
        $amount = -1 * $token_amount;

        event(new BlackTokenLogEvent(
            $sender_user_id,
            BlackTokenLog::ACTION_DEBIT,
            BlackTokenLog::TYPE_WALL,
            $amount,
            "",
            ""
        ));
    }
}
