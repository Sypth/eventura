<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications to all event attendees that event starts soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = \App\Models\Event::with('attendees.user')
            ->whereBetween('start_time', [now(), now()->addDays()])
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info("Found {$eventCount} {$eventLabel}");

        $events->each(function ($event) {
            $event->attendees->each(function ($attendee) {
                $this->info("Notify the user {$attendee->user->id}");
            });
        });

        $this->info('Reminder notification sent successfully!');

    }
}
