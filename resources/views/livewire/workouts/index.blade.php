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
    public $deleteModal = false; //sets visibility of delete modal
    public $deleteID; //set id to deleteID variable

    public $editModal = false; //sets visibility of edit modal
    public $editID; //set id to editID variable
    public $editName = '';
    public $editDesc = '';
    public $userId;


    // Table Format
    public array $headers = [
            ['key' => 'workout_id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Workout', 'class' => 'w-64'],
            ['key' => 'desc', 'label' => 'Description', 'sortable' => false]
        ];

    
    public $workouts;
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
    //upon triggering, will make edit modal visible
    public function showEditModal($id){
        $workouts = Workout::findOrFail($id);
        $this->editID = $id;
        $this->editName = $workouts->name;
        $this->editDesc = $workouts->desc;
        $this->editModal = true;
    }

    // Used to show popup confirm
    public function confirmEdit() {
        $this->validate(['editName'=>'required|min:3', 'editDesc'=>'required|min:3']);
        $workouts = Workout::findOrFail($this->editID);
        $workouts->name = $this->editName;
        $workouts->desc = $this->editDesc;
        $workouts->save();
        $this->workouts = Auth::user()->workouts()->get();
        $this->editModal = false;
    }

    // Brings to workout page for workout
    public function edit($id){
        redirect()->route('workout',['id'=>$id]);
    }

    //upon triggering, will make delete modal visible
    public function showDeleteModal($id){
        $this->deleteID = $id;
        $this->deleteModal = true;
    }
    //upon trigger, will trigger delete function
    public function confirmDelete() {
        $this->delete($this->deleteID);
        $this->deleteModal = false;
    }
    // Deletes workout sheet
    public function delete($id){
        $workout = Workout::findOrFail($id);
        $workout->delete();
        // Refresh the list of workouts after deletion
        $this->workouts = Auth::user()->workouts()->get();


    }

    #[Validate('required|min:3')] 
    public string $newName;
    public string $newDesc;

    // Creates workout
    public function create(){
        $this->validate();
        
        $workout = Workout::createWorkout($this->newName, $this->newDesc, $this->userId);

        $this->workouts = Auth::user()->workouts()->get();
        $this->resetCreate();
    }

    // Reset creation form
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
    <!--CREATE MODAL-->
    <x-modal wire:model="modal" class="backdrop-blur">
        <x-form wire:submit="create">
            <x-input label="Name" wire:model.blur="newName" value="{{ $newName }}"></x-input>
            <x-input label="Description" wire:model.blur="newDesc" value="{{ $newDesc }}"></x-input>
            <x-button label="Cancel" @click="$wire.modal = false" />
            <x-button label="Create" class="btn-primary" type="submit" @click="$wire.modal = false" />
        </x-form>
    </x-modal>
    <!--EDIT MODAL-->
    <x-modal wire:model="editModal" class="backdrop-blur">
        <x-form wire:submit.prevent="confirmEdit">
            <x-input label="Name" wire:model.blur="editName" />
            <x-input label="Description" wire:model.blur="editDesc" />
            <x-button label="Cancel" @click="$wire.editModal = false" />
            <x-button label="Apply" class="btn-primary" type="submit" @click="$wire.editModal = false" />
        </x-form>
    </x-modal>
    <!--DELETE MODAL-->
    <x-modal wire:model="deleteModal" class="backdrop-blur">
        <h2>Confirm Delete</h2>
        <p>Are you sure you want delete this workout?</p>
        <x-button label="Cancel" @click="$wire.deleteModal = false" />
        <x-button label="Delete" class="btn-primary" @click="$wire.confirmDelete" />
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
                        <x-button icon="c-arrow-right-end-on-rectangle" wire:click="edit('{{ $row['workout_id'] }}')"  spinner class="btn-sm" />
                        <x-button icon="o-pencil-square" wire:click="showEditModal('{{ $row['workout_id'] }}')" spinner class="btn-sm" />
                        <x-button icon="o-trash" wire:click="showDeleteModal('{{ $row['workout_id'] }}')" spinner class="btn-sm" />
                    </div>
                @endscope
        </x-table>
        <x-slot:actions>
            <x-button label="New" class="btn-primary" @click="$wire.modal = true" />
        </x-slot:actions>
    </x-card>
    
    
</div>
