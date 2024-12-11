<?php

namespace App\Models;

use App\Http\Controllers\AuthController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthTable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class User extends AuthTable
{
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'user_id'; // Primary key
    protected $keyType = 'string'; // UUID type
    public $incrementing = false; // No auto-incrementing

    protected $fillable = ['user_name', 'email','password']; // Fillable fields

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public static function createUser($name, $password, $email)
    {

        //($name, $password, $email)
        // Check if a test user already exists to avoid duplicates
        $testUser = User::where('email', $email)->first();

        $testUserName = User::where('user_name', $name)->first();

        if ((!$testUser) && (!$testUserName)) {
            $user = User::create([
                'user_name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            AuthController::loginUser($email,$password);
            return $user;
        }
    }


    public function workouts()
    {
        return $this->hasMany(Workout::class, 'user_id', 'user_id');
    }
}