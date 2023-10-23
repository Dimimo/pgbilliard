<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Date;
use App\Models\Event;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Policies\DatePolicy;
use App\Policies\EventPolicy;
use App\Policies\PlayerPolicy;
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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
