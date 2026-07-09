<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\ChatRoom;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $oldChats = ChatRoom::where('is_saved', false)
        ->where('is_archived', false)
        ->where('updated_at', '<', now()->subDay())
        ->get();

    foreach ($oldChats as $chat) {
        $chat->messages()->delete();
        $chat->delete();
    }
})->hourly()->name('delete-inactive-chats')->withoutOverlapping();

Schedule::call(function () {
    \App\Models\ActivityLog::where('created_at', '<', now()->subDays(30))->delete();
})->daily()->name('delete-old-activity-logs')->withoutOverlapping();
