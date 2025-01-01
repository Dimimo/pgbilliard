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
    use LogEventsTrait;
    use ConsolidateTrait;

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

    private function updateScores(): void
    {
        $this->score1 = $this->event->score1;
        $this->score2 = $this->event->score2;
        if ($this->score1 + $this->score2 > 15) {
            $this->addError('score1', 'More than 15 games? Please correct this...');
        }
        $this->confirmed = $this->event->confirmed;
    }


}
