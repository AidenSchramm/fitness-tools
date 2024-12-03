<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    public $email = '';
    public $cEmail = '';
}


?>

<div>
    <x-card>
        <x-form wire:submit="signIn">
            <x-input label="Email" wire:model="email"></x-input>
            <x-input label="Confirm Email" wire:model="cEmail"></x-input>
            <x-slot:actions>
                <x-button label="Create Account" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>