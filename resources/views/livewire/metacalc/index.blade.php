<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

use Illuminate\Http\Request;


new class extends Component {
    use Toast;

    public $weight = 150;
    public $age = 18;
    public $feet = 5;
    public $inches = 8;
    public int $rate = 0;
    
    public $sex = [[ 'name' => "Male", 'id' => 0, 'selected' => true], [ 'name' => "Female", 'id' => 1]];

    public $selected;
    public function save(Request $request)
    {
        
        // Male: BMR = 66.47 + ( 6.24 × weight in pounds ) + ( 12.7 × height in inches ) – ( 6.755 × age in years )
        // Female: BMR = 655.1 + ( 4.35 × weight in pounds ) + ( 4.7 × height in inches ) - ( 4.676 × age in years )

        error_log($this->selected);
        
        if ($this->selected == 0) {
            $this->rate = 66.47 + ( 6.24 * $this->weight ) + (12.7 * (($this->feet * 12) + $this->inches)) - (6.755 * $this->age);
        }
        elseif ($this->selected == 1) {
            $this->rate = 655.1 + ( 4.35 * $this->weight ) + ( 4.7 * (($this->feet * 12) + $this->inches)) - (4.676 * $this->age);
        }
        else {
            $this->rate = -1;
        }
        
    }
}; ?>

<div>
    <x-card>
        <x-form wire:submit="save">
            <x-input label="Age" wire:model='age' value="{{ $age }}" type="number"/>
            <x-radio label="Sex" :options="$sex" wire:model='selected'/>
            <div style="display: flex">
                <x-input label="feet" wire:model='feet' value="{{ $feet }}" type="number"/>
                <x-input label="inches" wire:model='inches' value="{{ $inches }}" type="number"/>
            </div>
            <x-input label="Weight" wire:model='weight' value="{{ $weight }}" type="number" suffix="lbs"/>
            <x-slot:actions>
                <div style="margin-right: auto; margin-left:1em">{!! $rate !!} kcal / day</div>
                <x-button label="Calculate" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
