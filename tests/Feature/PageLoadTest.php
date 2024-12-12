<?php

namespace Tests\Feature;

use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class PageLoadTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;


    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_metacalc_returns_a_successful_response(): void
    {
        $response = $this->get('/metacalc');

        $response->assertStatus(200);
    }

    public function test_bmi_returns_a_successful_response(): void
    {
        $response = $this->get('/bmicalc');

        $response->assertStatus(200);
    }

    public function test_fatcalc_returns_a_successful_response(): void
    {
        $response = $this->get('/fatcalc');

        $response->assertStatus(200);
    }

    public function test_workouts_returns_a_successful_response(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/workouts');

        $response->assertStatus(200);

        $response->assertOk()->assertSee(['<table', '</table>'], false);
    }

    public function test_workouts_goes_to_login_response(): void
    {
        $user = User::factory()->create();

        $this->followingRedirects();

        $response = $this->get('/workouts');

        $response->assertStatus(200);


        $response->assertSee('Email', false);
    }

    public function test_workouts_create_workout(): void
    {
        $user = User::factory()->create();
        $workout = Workout::factory()->create();

        $response = $this->actingAs($user)->get('/workouts');

        $response->assertStatus(200);


        $response->assertSee($workout->name);
    }

}
