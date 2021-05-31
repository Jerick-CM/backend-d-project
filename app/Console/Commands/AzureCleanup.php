<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\CartItem;
use App\Models\Department;
use App\Models\LikedMessage;
use App\Models\Message;
use App\Models\MessageBadge;
use App\Models\MessageToken;
use App\Models\Position;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AzureCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'azure:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive messages, users, etc. that are supposed to be excluded';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $excludedPositionNames = explode(',', config('cron.sync_interns'));
        $excludedPositions = Position::whereIn('name', $excludedPositionNames)->get();

        if (! $excludedPositions) {
            $excludedPositions = [];
        }

        $excludedPositions = $excludedPositions->map(function ($item) {
            return $item['id'];
        });

        $excludedDepartmentNames = explode(',', config('cron.sync_exclude_departments'));
        $excludedDepartments = Department::whereIn('name', $excludedDepartmentNames)->get();

        if (! $excludedDepartments) {
            $excludedDepartments = [];
        }

        $excludedDepartments = $excludedDepartments->map(function ($item) {
            return $item['id'];
        });

        $excludedUsers = User::whereNull('department_id')
            ->orWhereIn('department_id', $excludedDepartments)
            ->orWhereIn('position_id', $excludedPositions)
            ->get();

        $excludedUsers = $excludedUsers->map(function ($item) {
            return $item['id'];
        });

        DB::transaction(function () use ($excludedUsers, $excludedDepartments) {
            LikedMessage::whereIn('user_id', $excludedUsers)
                ->delete();

            Message::whereIn('sender_user_id', $excludedUsers)
                ->orWhereIn('recipient_user_id', $excludedUsers)
                ->delete();

            MessageBadge::whereIn('sender_user_id', $excludedUsers)
                ->orWhereIn('recipient_user_id', $excludedUsers)
                ->delete();

            MessageToken::whereIn('sender_user_id', $excludedUsers)
                ->orWhereIn('recipient_user_id', $excludedUsers)
                ->delete();

            CartItem::whereIn('user_id', $excludedUsers)
                ->delete();

            User::whereIn('id', $excludedUsers)
                ->delete();

            Department::whereIn('id', $excludedDepartments)
                ->delete();
        });
    }
}
