<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\{Event, Attendee};
//use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('update-event', function($user, Event $event) {
            return $user->id === $event->user_id;
        });

        Gate::define('delete-attendee', function($user, Event $event, Attendee $attendee) {
            return $user->id === $event->user_id || $user->id === $attendee->user_id;
        });
    }
}
