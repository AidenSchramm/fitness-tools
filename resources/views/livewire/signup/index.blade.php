<?php

use App\Models\User;
use Livewire\Attributes\Validate; 
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Reactive;

new class extends Component {
    use Toast;

    #[Modelable]
    #[Validate('required|min:3')] 
    public $username = '';
    #[Modelable]
    #[Validate('required|email|unique:users')] 
    public $email = '';
    #[Modelable]
    #[Validate('required|email|unique:users')] 
    public $cEmail = '';

    public function save() {
        $this->validate(); 
        if($this->email == $this->cEmail){
            User::createUser($this->username, $this->email);
        }
    }
}; ?>

<div>
    <x-card>
        <x-form wire:submit="save" @keydown.meta.enter="$wire.save()">
            <x-input label="Username" wire:model.blur="username" value="{{ $username }}"></x-input>
            <x-input label="Email" wire:model.blur="email" value="{{ $email }}"></x-input>
            <x-input label="Confirm Email" wire:model.blur="cEmail" value="{{ $cEmail }}"></x-input>
            <x-slot:actions>
                <x-button label="Create Account" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>