<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Exercise extends Model
{
    use HasFactory;

    protected $primaryKey = 'exercise_id'; // Primary key
    protected $keyType = 'string'; // UUID type
    public $incrementing = false; // No auto-incrementing

    protected $fillable = ['name', 'desc', 'sets', 'reps', 'duration', 'workout_id']; // Fillable fields

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Get connected workout
    public function workout()
    {
        return $this->belongsTo(Workout::class, 'workout_id', 'workout_id');
    }

    // Can be used to create new exercise object
    public static function createExercise(string $name, string $desc, int $sets, int $reps, $duration, string $workout_id) {
            return Exercise::create([
                'name' => $name,
                'desc' => $desc,
                'sets' => $sets,
                'reps' => $reps,
                'duration' => $duration,
                'workout_id' => $workout_id,
            ]);
    }

}