<?php

use App\Models\User;
use Livewire\Attributes\Validate; 
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Reactive;

new class extends Component {
    use Toast;

    #[Validate('required|min:3')] 
    public $name = '';

    #[Validate('required|min:8')] 
    public $password = '';

    #[Validate('required|email|unique:users')] 
    public $email = '';

    #[Validate('required|email|unique:users')] 
    public $cEmail = '';

    

    public function save() {
        $this->validate(); 

        
        if(($this->email) == ($this->cEmail)){
            $output = User::createUser($this->name, $this->password, $this->email);
            if($output == null){
                $this->addError('email', 'The provided credentials do not match our records.');
            }
        }


        
    }

    
}; ?>

<div>
    <x-card>
        <x-form wire:submit="save" @keydown.meta.enter="$wire.save()" >
            <x-input label="Username" wire:model.blur="name" value="{{ $name }}"></x-input>
            <x-input label="Email" wire:model.blur="email" value="{{ $email }}"></x-input>
            <x-input label="Confirm Email" wire:model.blur="cEmail" value="{{ $cEmail }}"></x-input>
            <x-input label="Password" wire:model.blur="password" value="{{ $password }}"></x-input>
            <x-slot:actions>
                <x-button label="Create Account" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>