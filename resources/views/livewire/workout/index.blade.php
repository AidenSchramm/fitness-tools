<?php

use App\Models\Workout;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $id;
    public $workoutName;
    public $desc;

    public array $headers = [
            ['key' => 'exercise_id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Exercise', 'class' => 'w-64'],
            ['key' => 'desc', 'label' => 'Description', 'sortable' => false],
            ['key' => 'sets', 'label' => 'Sets', 'class'],
            ['key' => 'reps', 'label' => 'Reps', 'class'],
            ['key' => 'duration', 'label' => 'Duration', 'class']
        ];


    public function workouts(): Collection {
        return collect([
            ['id' => 1, 'exercise_id' => '1', 'name' => 'Bench press', 'desc' => 'lift bar up n down', 'sets' => '4', 'reps' => '8', 'duration' => '0'],
            ['id' => 2, 'exercise_id' => '2', 'name' => 'Squat', 'desc' => 'legs go up n down', 'sets' => '4', 'reps' => '8', 'duration' => '0']
            ]);
    }

    public function with(): array
    {
        return [
            'workouts' => $this->workouts(),
        ];
    }

    public function mount($id) {
        $this->id = $id;

        $workout = Workout::find($id);
        $exercises = $workout->exercises();
        $this->workoutName = $workout->name;
        $this->exercises = $workout->exercises()->get();
        $this->desc = $workout->desc;


    }
};
?>

<div>
    <!-- HEADER -->
    {{$id}}
    <x-header title="{{ $workoutName }}" seperator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Filters" @click="$wire.drawer = true" responsive icon="o-funnel" />
        </x-slot:actions>
    </x-header>
    {{$desc}}

    <!-- Workout TABLE -->
    <x-card>
        <x-table :headers="$headers" :rows="$workouts"  >
            @scope('cell_id', $row)
            <div style="display: flex">
            </div>
            @endscope
            @scope('actions', $row)
            <div style="display: flex">
                <x-button icon="o-pencil-square" wire:click="edit('{{ $row['workout_id'] }}')"  spinner class="btn-sm" />
                <x-button icon="o-trash" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
</div>
