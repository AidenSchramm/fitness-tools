<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="p-5 pt-3" />

            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User --}}
                @auth
                    <x-menu-separator title="Account" icon="o-user"/>

                    <!-- <p>Welcome, {{ Auth::user()->user_name }}!</p> -->
                    <x-list-item :item="auth()->user()" value="name" sub-value="email" no-separator no-hover class="!mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            {{-- <x-form action="{{ route('logout') }}" method="POST"> --}}
                            <x-form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" type="submit" no-wire-navigate  />
                            </x-form>
                        </x-slot:actions>
                    </x-list-item>

                    
                @else
                    <x-menu-separator title="Account" icon="o-user"/>

                    <x-menu-item title="Login" link="/login" />
                    <x-menu-item title="Sign Up" link="/signup" />

                @endauth


                <x-menu-separator Title="Trackers" icon="o-list-bullet"/>
                    <x-menu-item title="Workouts"  link="/workouts" />


                <x-menu-separator title="Calculators" icon="o-calculator" />
                    <x-menu-item title="Metabolic Rate" link="/metacalc" />
                    <x-menu-item title="BMI" link="/bmicalc" />
                    <x-menu-item title="Body Fat" link="/fatcalc" />
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
