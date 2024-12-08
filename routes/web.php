<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Volt::route('/', 'users.index');

Volt::route('/metacalc', 'metacalc.index');
Volt::route('/bmicalc', 'bmicalc.index');
Volt::route('/fatcalc', 'fatcalc.index');

Volt::route('/login', 'login.index')->name('login');


Volt::route('/signup', 'signup.index');

Volt::route('/workouts', 'workouts.index');


?>