<?php

namespace App\Livewire\Monitors;

use App\Enums\MonitorStatus;
use App\Models\Monitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public ?int $monitorId = null;

    public string $name = '';

    public string $target = '';

    public string $type = 'http';

    public string $frequency = '5m';

    public int $timeout = 10;

    public bool $isActive = true;

    public bool $saved = false;

    public function mount(?string $monitor = null): void
    {
        if ($monitor === null) {
            return;
        }

        $existing = $this->findMonitor($monitor);

        $this->monitorId = $existing->id;
        $this->name = $existing->name;
        $this->target = $existing->target;
        $this->type = $existing->type;
        $this->frequency = $existing->frequency;
        $this->timeout = $existing->timeout;
        $this->isActive = $existing->isActive();
    }

    public function save(): void
    {
        $validated = $this->validate();

        $validated['user_id'] = Auth::id();
        $validated['status'] = $this->isActive
            ? MonitorStatus::Active
            : MonitorStatus::Paused;

        if ($this->monitorId !== null) {
            $this->findMonitor((string) $this->monitorId)->update($validated);
        } else {
            Monitor::query()->create($validated);
        }

        $this->saved = true;

        $this->redirectRoute('monitors.index', navigate: true);
    }

    protected function rules(): array
    {
        $targetRules = $this->type === 'ping'
            ? ['required', 'ip']
            : ['required', 'url', 'regex:/^https?:\/\/[^\\s]+$/i'];

        return [
            'name' => ['required', 'string', 'max:120'],
            'target' => [...$targetRules, 'max:255'],
            'type' => ['required', Rule::in(['http', 'ping'])],
            'frequency' => ['required', Rule::in(['1m', '5m'])],
            'timeout' => ['required', 'integer', 'min:1', 'max:60'],
            'isActive' => ['boolean'],
        ];
    }

    protected function messages(): array
    {
        return [
            'target.url' => 'Informe uma URL valida com http:// ou https://.',
            'target.regex' => 'A URL precisa iniciar com http:// ou https://.',
            'target.ip' => 'Informe um IP valido para monitores de ping.',
        ];
    }

    private function findMonitor(string $monitor): Monitor
    {
        return Monitor::query()
            ->where('user_id', Auth::id())
            ->findOrFail($monitor);
    }

    public function render()
    {
        return view('livewire.monitors.form', [
            'isEditing' => $this->monitorId !== null,
        ]);
    }
}
