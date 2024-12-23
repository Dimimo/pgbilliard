<?php

namespace App\Livewire\Date;

use App\Mail\DayScoresConfirmed;
use App\Mail\DayScoresToAdmin;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public Event $event;

    #[Validate]
    public ?int $score1 = null;

    #[Validate]
    public ?int $score2 = null;

    public bool $confirmed = false;

    public function rules(): array
    {
        return [
            'score1' => ['nullable', 'integer', 'between:0,15'],
            'score2' => ['nullable', 'integer', 'between:0,15'],
        ];
    }

    public function messages(): array
    {
        return [
            'score1.between' => 'The score must be between 0 and 15',
            'score2.between' => 'The score must be between 0 and 15',
        ];
    }

    public function mount(): void
    {
        $this->updateScores();
    }

    public function render(): View
    {
        return view('livewire.date.update');
    }

    public function updated($field, $value): void
    {
        $this->validateOnly($field);
        $this->event->update([$field => $value]);
        $this->updateScores();
        $this->dispatch('scores-updated-'.$this->event->id);
        $this->logChanges($field);
    }

    public function change(string $field, string $action = 'increment'): void
    {
        $action === 'increment' ? $this->$field += 1 : $this->$field -= 1;
        $this->validate();
        if (is_null($this->event->$field)) {
            $this->event->update([$field => 0]);
        }
        $this->event->$action($field);
        $this->updateScores();
        $this->dispatch('scores-updated-'.$this->event->id);
        $this->logChanges($field);
    }

    public function consolidate(): void
    {
        $this->event->update(['confirmed' => true]);
        $this->confirmed = true;
        $this->dispatch('score-confirmed-'.$this->event->id);
        $this->logConsolidate();

        // here we check if all events are confirmed, if so, email all participating players, only in production!
        if ($this->event->date->events->every(fn ($value) => $value->confirmed === true)) {
            if (app()->environment() === 'production') {
                $send_to = [];
                $players = $this->event->date->players();
                foreach ($players as $user) {
                    // avoid players that haven't been claimed yet
                    if (!Str::contains($user->email, '@pgbilliard.com')) {
                        \Mail::to($user)->queue(new DayScoresConfirmed($this->event->date));
                        $send_to = \Arr::add($send_to, $user->id, $user->name);
                    }
                }
                \Mail::queue(new DayScoresToAdmin($this->event->date, \Arr::sort($send_to)));
                $message = "All day scores confirmed, " . count($send_to) . " emails have been sent";
                $this->buildLogChannel()->info($message);
                date_default_timezone_set(config('app.timezone'));

            }
        }
    }

    private function updateScores(): void
    {
        $this->score1 = $this->event->score1;
        $this->score2 = $this->event->score2;
        if ($this->score1 + $this->score2 > 15) {
            $this->addError('score1', 'More than 15 games? Please correct this...');
        }
        $this->confirmed = $this->event->confirmed;
    }

    private function logChanges(string $field): void
    {
        $message = "["
            . $this->event->date->date->appTimezone()->format("d/m/Y")
            . " {$this->event->team_1->name} - {$this->event->team_2->name}  ($this->score1 - $this->score2)] "
            . auth()->user()->name
            . " changed $field to "
            . $this->$field;

        $this->buildLogChannel()->info($message);
        date_default_timezone_set(config('app.timezone'));
    }

    private function logConsolidate(): void
    {
        $message = "["
            . $this->event->date->date->appTimezone()->format("d/m/Y")
            . " {$this->event->team_1->name} - {$this->event->team_2->name}] "
            . auth()->user()->name
            . " confirmed the game, end score is $this->score1 - $this->score2";

        $this->buildLogChannel()->info($message);
        date_default_timezone_set(config('app.timezone'));
    }

    private function buildLogChannel(): \Psr\Log\LoggerInterface
    {
        date_default_timezone_set(config('app.app_timezone'));

        return \Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/scores.log'),
        ]);
    }
}
