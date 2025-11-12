<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

use App\Models\User;

class Personality extends Model
{
    /** @use HasFactory<\Database\Factories\PersonalityFactory> */
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_id',
        'gender',
        'age',
        'weight',
        'height',
        'activity_level',
        'bmr',
        'tdee',
        'goal',
        'diet_type',
        'allergies',
        'health_goals',
        'religion',
        'custom_preferences',
    ];

    /**
     * Attribute casting.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'age' => 'integer',
        'weight' => 'float',
        'height' => 'float',
        'bmr' => 'float',
        'tdee' => 'float',
        'allergies' => 'array',
        'health_goals' => 'array',
        'custom_preferences' => 'array',
    ];

    /**
     * Personality belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
