<?php

use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

    public $exercises;

    public $modal;
    public string $newDesc = '';
    public string $newName = '';
    #[Validate('required', message: 'Sets is required')]
    #[Validate('integer', message: 'Sets must be a integer')]
    public $newSets = 1;
    #[Validate('required', message: 'Reps is required')]
    #[Validate('integer', message: 'Reps must be a integer')]
    public $newReps = 1;

    public $newDuration;
    public $editModal = false; //sets visibility of edit modal
    public $editID; //set id to editID variable
    public $editName = '';
    public $editDesc = '';
    public $editSets;
    public $editReps;

    public array $headers = [
            ['key' => 'exercise_id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Exercise', 'class' => 'w-64'],
            ['key' => 'desc', 'label' => 'Description', 'sortable' => false],
            ['key' => 'sets', 'label' => 'Sets', 'class'],
            ['key' => 'reps', 'label' => 'Reps', 'class'],
            ['key' => 'duration', 'label' => 'Duration', 'class']
        ];

    public function with(): array
    {
        return [
            'workouts' => $this->exercises,
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

    //upon triggering, will make edit modal visible
    public function showEditModal($id){
        $exercises = Exercise::findOrFail($id);
        $this->editID = $id;
        $this->editName = $exercises->name;
        $this->editDesc = $exercises->desc;
        $this->editSets = $exercises->sets;
        $this->editReps = $exercises->reps;
        $this->editModal = true;
    }
    public function confirmEdit() {
        $this->validate(['editName'=>'required|min:3', 'editDesc'=>'required|min:3', 'editSets'=>'integer', 'editReps'=>'integer']);
        $exercises = Exercise::findOrFail($this->editID);
        $exercises->name = $this->editName;
        $exercises->desc = $this->editDesc;
        $exercises->sets = $this->editSets;
        $exercises->reps = $this->editReps;
        $exercises->save();
        $this->exercises = $this->workout->exercises()->get();
        $this->editModal = false;
    }

    

    public function delete($id) {
        $exercises = Exercise::findOrFail($id);
        $exercises->delete();

        // Refresh the list of exercises after deletion
        $this->exercises = $this->workout->exercises()->get();
        $this->exerciseCnt = $this->exercises->count();
    }

    public function create(): void{
        $this->validate();
        $this->modal = false;
        $this->workout->createExercise($this->newName, $this->newDesc, $this->newSets, $this->newReps, $this->newDuration);
        $this->exercises = $this->workout->exercises()->get();
        $this->exerciseCnt = $this->exercises->count();
    }


};

?>

<div>
    <!-- HEADER -->
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

    <!--EDIT EXERCISE MODAL-->
    <x-modal wire:model="editModal" class="backdrop-blur">
        <x-form wire:submit.prevent="confirmEdit">
            <x-input label="Name" wire:model.blur="editName" />
            <x-input label="Description" wire:model.blur="editDesc" />
            <x-input label="Sets" wire:model.blur="editSets" />
            <x-input label="Reps" wire:model.blur="editReps" />
            <x-button label="Cancel" @click="$wire.editModal = false" />
            <x-button label="Apply" class="btn-primary" type="submit" @click="$wire.editModal = false" />
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
                <x-button icon="o-pencil-square" wire:click="showEditModal('{{ $row['exercise_id'] }}')" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete('{{ $row['exercise_id'] }}')" spinner class="btn-sm" />

            </div>
            @endscope
        </x-table>
        <x-slot:actions>
            <x-button label="New" class="btn-primary" @click="$wire.modal = true" />
        </x-slot:actions>
    </x-card>
</div>
