<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;


new class extends Component {
    use Toast;

    public $weight = 150;
    public $age = 18;
    public $feet = 5;
    public $inches = 8;
    public float $rate = 0;
    
    public $SexOptions = [[ 'name' => "Male", 'id' => 0, 'selected' => true], [ 'name' => "Female", 'id' => 1]];

    public function save()
    {
        $this->rate = $this->weight;
    }
}; ?>

<div>
    <x-card>
        <x-form wire:submit="save">
            <x-input label="Age" wire:model='age' value="{{ $age }}" type="number"/>
            <x-radio label="Sex" :options="$SexOptions" selected/>
            <div style="display: flex">
                <x-input label="feet" wire:model='feet' value="{{ $feet }}" type="number"/>
                <x-input label="inches" wire:model='inches' value="{{ $inches }}" type="number"/>
            </div>
            <x-input label="Weight" wire:model='weight' value="{{ $weight }}" type="number" suffix="lbs"/>
            <x-slot:actions>
                <x-button label="Calculate" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>

        <div>{!! $rate !!}</div>
    </x-card>
</div>
