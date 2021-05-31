<?php

namespace App\Helpers;

use App\Models\CollectionBlock;
use Carbon\Carbon;
use App\Models\Settings;

class CollectionHelper
{
    public static function getNextCollectionDate($startDate = null)
    {
        /*
        $found = false;

        $now = Carbon::now();

        if (is_null($startDate) && $now->dayOfWeek < Carbon::THURSDAY) {
            $startDate = $now;
        } elseif ($now->dayOfWeek > Carbon::WEDNESDAY) {
            $startDate = $now->addWeeks(1);
        } else {
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
        }

        if ($startDate->dayOfWeek != Carbon::FRIDAY) {
            $next = $startDate->next(Carbon::FRIDAY);
        } else {
            $next = $startDate;
        }

        while (! $found) {
            $isBlocked = CollectionBlock::where('date', $next->toDateString())->count();

            if ($isBlocked) {
                $next = $next->next(Carbon::FRIDAY);
            } else {
                $found = true;
            }
        }

        return $next->toDateString();
        */

        $blockDays = Settings::where('setting', 'blockedDays', 1)->first();
        $blockDays = json_decode($blockDays['data'], true);
        if ($startDate === null) {
            $date = date('Y-m-d');
            $date = strtotime($date);
            $date = strtotime("+6 day", $date);
            $date = date('Y-m-d', $date);
        } else {
            $date = date('Y-m-d', strtotime($startDate));
        }

        $done = false;
        do {
            $date = strtotime($date);
            $date = strtotime("+1 day", $date);
            $date = date('Y-m-d', $date);
            $day = ucfirst(strtolower(date('l', strtotime($date))));
            if ($blockDays['is' . $day . 'Enabled']) {
                $isBlocked = CollectionBlock::where('date', $date)->count();
                if (!$isBlocked) {
                    $done = true;
                }
            }
        } while (!$done);
        return Carbon::createFromFormat('Y-m-d', $date)->toDateString();
    }
}
