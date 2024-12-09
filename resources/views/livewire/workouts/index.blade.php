<?php

use App\Models\Workout;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Validate; 
use Illuminate\Support\Facades\Auth;
new class extends Component {
    use Toast;

    public $modal;

    public $userId;

    public array $headers = [
            ['key' => 'workout_id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Workout', 'class' => 'w-64'],
            ['key' => 'desc', 'label' => 'Description', 'sortable' => false]
        ];

    
    public $workout;
    // public function workouts(): Collection {
    //     return collect([
    //         ['id' => 1, 'workout_id' => '1', 'name' => 'Workout1', 'desc' => 'description 1'],
    //         ['id' => 2, 'workout_id' => '2', 'name' => 'Workout2', 'desc' => 'description 2'],
    //         ['id' => 3, 'workout_id' => '3', 'name' => 'Workout3', 'desc' => 'description 3'],
    //         ]);
    // }

    public function with(): array
    {
        return [
            'workouts' => $this->workouts,
        ];
    }

    // Gets the ID of the signed in user on pageload
    public function mount(){
        $user=Auth::user();
        $this->userId= $user->user_id;
        $this->workouts = $user->workouts()->get();
    }
    
    public function edit($id){
        redirect()->route('workout', ['id' => $id]);
    }


    // TODO
    // Change to delete from data base later
    public function delete($id){
        Log::info($id); 
        redirect()->route('workout', ['id' => $id]);
    }

    #[Validate('required|min:3')] 
    public string $newName;
    public string $newDesc;

    public function create(){
        $this->validate();
        
        Workout::createWorkout($this->newName, $this->newDesc, $this->userId);
    }

    public function resetCreate(){
        $this->newName = '';
        $this->newDesc = '';
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
    {{$newName}}
    <x-modal wire:model="modal" class="backdrop-blur">
        <x-form wire:submit="create">
            <x-input label="Name" wire:model.blur="newName" value="{{ $newName }}"></x-input>
            <x-input label="Description" wire:model.blur="newDesc" value="{{ $newDesc }}"></x-input>
            <x-button label="Cancel" @click="$wire.modal = false" />
            <x-button label="Create" type="submit" @click="$wire.modal = false" />
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
                        <x-button icon="o-pencil-square" wire:click="edit('{{ $row['workout_id'] }}')"  spinner class="btn-sm" />
                        <x-button icon="o-trash" spinner class="btn-sm" />
                    </div>
                @endscope
        </x-table>
        <x-slot:actions>
            <x-button label="New" class="btn-primary" @click="$wire.modal = true" />
        </x-slot:actions>
    </x-card>
    
    
</div>
