<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public $weight       = 150;
    public $age          = 18;
    
    public $height_feet  = 5;
    public $height_inch  = 8;
    
    public $neck_feet    = 1;
    public $neck_inch    = 7;
    
    public $abdomen_feet = 3;
    public $abdomen_inch = 1;
    
    public $hip_feet     = 2;
    public $hip_inch     = 10;

    public $bodyfat      = 21.5;
    
    
    public float $bmi = 23.0;
    
    public $sex = [[ 'name' => "Male", 'id' => 0, 'selected' => true], [ 'name' => "Female", 'id' => 1]];

    public $selected;
    public $show = false;

    public function save()
    {
        
        // Body Mass Index:  703 * ( pounds / inches^2 ) = BMI  	
        
        // Body Fat Men:      BFP = 86.010  × log10(abdomen-neck)   - 70.041 × log10(height) + 36.76
        // Body Fat Women:    BFP = 163.205 × log10(waist+hip-neck) - 97.684 × (log10(height)) - 78.387

        error_log($this->selected);
        
        $temp_height  = (($this->height_feet  * 12) + $this->height_inch);
        $temp_abdomen = (($this->abdomen_feet * 12) + $this->abdomen_inch);
        $temp_neck    = (($this->neck_feet    * 12) + $this->neck_inch);
        $temp_hip     = (($this->hip_feet     * 12) + $this->hip_inch);
        

        
        if ($this->selected == 0) {
            $this->bodyfat = (86.010 * log($temp_abdomen - $temp_neck, 10)) - 70.041 * log($temp_height, 10) + 36.76;
            $this->show = false;
        }
        elseif ($this->selected == 1) {
            $this->bodyfat = 163.205 * log($temp_abdomen + $temp_hip - $temp_neck, 10) - 97.684 * log($temp_height, 10) - 78.387;
            $this->show = true;
        }
        else {
            $this->rate = -1;
        }

        error_log($this->bmi);
        $this->bodyfat = number_format((float)$this->bodyfat, 1, '.', '');
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
                <x-input label="Height feet" wire:model.blur='height_feet' value="{{ $height_feet }}" type="number"/>
                <x-input label="Height inches" wire:model.blur='height_inch' value="{{ $height_inch }}" type="number"/>
            </div>
            
            <div style="display: flex">
                <x-input label="Neck feet" wire:model.blur='neck_feet' value="{{ $neck_feet }}" type="number"/>
                <x-input label="Neck inch" wire:model.blur='neck_inch' value="{{ $neck_inch }}" type="number"/>
            </div>
            
            <div style="display: flex">
                <x-input label="Abdomen feet" wire:model.blur='abdomen_feet' value="{{ $abdomen_feet }}" type="number"/>
                <x-input label="Abdomen inch" wire:model.blur='abdomen_inch' value="{{ $abdomen_inch }}" type="number"/>
            </div>

            @if($show)
                <div style="display: flex">
                    <x-input label="Hip feet" wire:model.blur='hip_feet' value="{{ $hip_feet }}" type="number"/>
                    <x-input label="Hip inch" wire:model.blur='hip_inch' value="{{ $hip_inch }}" type="number"/>
                </div>
            @endif
        


            <x-input label="Weight" wire:model.blur='weight' value="{{ $weight }}" type="number" suffix="lbs"/>
            <x-slot:actions>
                <div wire:model.blur='bodyfat' style="margin-right: auto; margin-left:1em">{!! $bodyfat !!}% </div>
                <x-button label="Calculate" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
