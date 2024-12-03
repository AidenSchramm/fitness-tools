<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    public $email = '';
}


?>

<div>
    <x-card>
        <x-form wire:submit="login">
            <x-input label="Email" wire:model="email"></x-input>
            <x-slot:actions>
                <x-button label="login" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>