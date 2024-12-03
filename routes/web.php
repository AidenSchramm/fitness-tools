<?php

use Livewire\Volt\Volt;

Volt::route('/', 'users.index');

Volt::route('/metacalc', 'metacalc.index');
Volt::route('/bmicalc', 'bmicalc.index');
Volt::route('/fatcalc', 'fatcalc.index');
Volt::route('/login', 'login.index');

Volt::route('/signin', 'signin.index');


?>