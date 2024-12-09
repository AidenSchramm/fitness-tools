<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Exercise;

class Workout extends Model
{
    use HasFactory;

    protected $primaryKey = 'workout_id'; // Primary key
    protected $keyType = 'string'; // UUID type
    public $incrementing = false; // No auto-incrementing

    protected $fillable = ['name', 'desc', 'user_id']; // Fillable fields

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'workout_id', 'workout_id');
    }

    public function createExercise(string $name, string $desc, int $sets, int $reps, $duration){
        return Exercise::createExercise($name, $desc, $sets, $reps, $duration, $this->workout_id);
    }



    public static function createWorkout(string $name, string $desc, $userId){
        return Workout::create([
            'name' => $name,
            'desc' => $desc,
            'user_id' => $userId,
        ]);
    }
}