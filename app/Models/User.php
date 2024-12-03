<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthTable;
use Illuminate\Support\Str;

class User extends AuthTable
{
    use HasFactory;

    protected $primaryKey = 'user_id'; // Primary key
    protected $keyType = 'string'; // UUID type
    public $incrementing = false; // No auto-incrementing

    protected $fillable = ['user_name', 'user_email']; // Fillable fields

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class, 'user_id', 'user_id');
    }
    public function createTestUser()
    {
        // Check if a test user already exists to avoid duplicates
        $testUser = self::where('user_email', 'testuser@example.com')->first();

        if (!$testUser) {
            // Create a new test user
            $testUser = self::create([
                'user_name' => 'Test User',
                'user_email' => 'testuser@example.com',
            ]);
        }

        return $testUser;
    }
}


