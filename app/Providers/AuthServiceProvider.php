<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use App\Models\Date;
use App\Models\Event;
use App\Models\Format;
use App\Models\Game;
use App\Models\Player;
use App\Models\Schedule;
use App\Models\Season;
use App\Models\Team;
use App\Policies\ChatMessagePolicy;
use App\Policies\ChatRoomPolicy;
use App\Policies\DatePolicy;
use App\Policies\EventPolicy;
use App\Policies\FormatPolicy;
use App\Policies\GamePolicy;
use App\Policies\PlayerPolicy;
use App\Policies\SchedulePolicy;
use App\Policies\SeasonPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Date::class => DatePolicy::class,
        Event::class => EventPolicy::class,
        Player::class => PlayerPolicy::class,
        Season::class => SeasonPolicy::class,
        Team::class => TeamPolicy::class,
        ChatMessage::class => ChatMessagePolicy::class,
        ChatRoom::class => ChatRoomPolicy::class,
        Format::class => FormatPolicy::class,
        Schedule::class => SchedulePolicy::class,
        Game::class => GamePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
