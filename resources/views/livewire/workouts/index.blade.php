<?php

use App\Models\Workout;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public function headers(): array
    {
        return [
            ['key' => 'workout_id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Workout', 'class' => 'w-64'],
            ['key' => 'desc', 'label' => 'Description', 'sortable' => false]
        ];
    }




};
?>

<div>
    <!-- HEADER -->
    <x-header title="Workouts" seperator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>

    <!-- Workout TABLE -->
    <x-card>
        <x-table :header="$headers" :rows="workouts" link="/exercises/?from={user}">

        </x-table>
    </x-card>
</div>
