<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $weight = 150;
    public $age = 18;
    public $feet = 5;
    public $inches = 8;
    public float $bmi = 23.0;
    
    public $sex = [[ 'name' => "Male", 'id' => 0, 'selected' => true], [ 'name' => "Female", 'id' => 1]];

    public $selected;


    public function save()
    {
        
        // Body Mass Index:  703 * ( pounds / inches^2 ) = BMI  	

        error_log($this->selected);
        
        
        if ($this->selected == 0) {
            $this->bmi = 703 * ( ($this->weight) / pow((($this->feet * 12) + $this->inches), 2));
        }
        elseif ($this->selected == 1) {
            $this->bmi = 703 * ( ($this->weight) / pow((($this->feet * 12) + $this->inches), 2));
        }
        else {
            $this->rate = -1;
        }

        error_log($this->bmi);
        $this->bmi = number_format((float)$this->bmi, 1, '.', '');
        error_log($this->bmi);
        
    }
    public function updated($name, $value) 
    {
        $this->save();
    }

}; ?>

<div>
    <x-card>
        <x-form wire:submit="save">
            <x-input label="Age" wire:model.blur='age' value="{{ $age }}" type="number"/>
            <x-radio label="Sex" :options="$sex" wire:model.live='selected'/>
            <div style="display: flex">
                <x-input label="feet" wire:model.blur='feet' value="{{ $feet }}" type="number"/>
                <x-input label="inches" wire:model.blur='inches' value="{{ $inches }}" type="number"/>
            </div>
            <x-input label="Weight" wire:model.blur='weight' value="{{ $weight }}" type="number" suffix="lbs"/>
            <x-slot:actions>
                <div wire:model.blur='bmi' style="margin-right: auto; margin-left:1em">{!! $bmi !!} </div>
                <x-button label="Calculate" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
