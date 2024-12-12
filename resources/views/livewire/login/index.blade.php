<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;
use Livewire\Attributes\Validate; 
use App\Models\User;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Context;
use Illuminate\Http\Request;


new class extends Component {
    #[Validate('required|email')] 
    public $email = '';
    #[Validate('required|min:6')] 
    public $password = '';

    public function login(Request $request)
    {

        $this->validate(); 

        AuthController::loginUser($this->email, $this->password);
    }
}


?>

<div>
    <x-card>
        <x-form wire:submit="login">
            <x-input label="Email" wire:model="email"></x-input>
            <x-input label="Password" wire:model="password"></x-input>
            <x-slot:actions>
                <x-button label="login" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>