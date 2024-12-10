<?php

use App\Models\Workout;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Reactive;
use function Livewire\Volt\{state};

new class extends Component {
    use Toast;

    public $id;
    public $workoutName;
    public $desc;
    public int $exerciseCnt;

    public $workout;

    public $modal;
    public string $newDesc;
    public string $newName;
    #[Validate('required', message: 'Sets is required')]
    #[Validate('integer', message: 'Sets must be a integer')]
    public $newSets = 1;
    #[Validate('required', message: 'Reps is required')]
    #[Validate('integer', message: 'Reps must be a integer')]
    public $newReps = 1;

    public $newDuration;

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

        $this->workout = Workout::find($id);
        $exercises = $this->workout->exercises();
        $this->exerciseCnt =$exercises->count();
        $this->workoutName = $this->workout->name;
        $this->exercises = $this->workout->exercises()->get();
        $this->desc = $this->workout->desc;


    }
    public function create(): void{
        $this->validate();
        $this->modal = false;
        $this->workout->createExercise($this->newName, $this->newDesc, $this->newSets, $this->newReps, $this->newDuration);
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

    <!-- New Exercise Modal -->

    <x-modal wire:model="modal" class="backdrop-blur">
        <x-form wire:submit.prevent="create">
            <x-input label="Name" wire:model.blur="newName" value="{{ $newName }}"></x-input>
            <x-input label="Description" wire:model.blur="newDesc" value="{{ $newDesc }}"></x-input>
            <x-input label="Sets" wire:model.blur="newSets" value="{{ $newSets }}"></x-input>
            <x-input label="Reps" wire:model.blur="newReps" value="{{ $newReps }}"></x-input>
            <x-button label="Cancel" @click="$wire.modal = false" />
            <x-button label="Create" class="btn-primary" type="submit"/>
        </x-form>
    </x-modal>

    <!-- Workout TABLE -->
    <x-card>
        <x-table :headers="$headers" :rows="$workouts"  >
            @scope('cell_id', $row)
            <div style="display: flex">
            </div>
            @endscope
            @scope('actions', $row)
            <div style="display: flex">
                <x-button icon="o-pencil-square" wire:click="edit('{{ $row['exercise_id'] }}')"  spinner class="btn-sm" />
                <x-button icon="o-trash" spinner class="btn-sm" />
            </div>
            @endscope
        </x-table>
        <x-slot:actions>
            <x-button label="New" class="btn-primary" @click="$wire.modal = true" />
        </x-slot:actions>
    </x-card>
</div>
