<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;
use Livewire\Attributes\Validate; 
use App\Models\User;



new class extends Component {
    #[Validate('required|email')] 
    public $email = '';
    #[Validate('required|min:6')] 
    public $password = '';

    public function login()
    {

        $this->validate(); 

        User::loginUser($this->email, $this->password);
        // if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
        //     session()->regenerate();
        //     return redirect()->intended('/dashboard'); // Redirect to dashboard or desired page
        // }

        //  $this->addError('email', 'The provided credentials do not match our records.');
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