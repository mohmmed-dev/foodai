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
     * 🔹 حساب تلقائي لـ BMR وTDEE و السعرات عند إنشاء أو تحديث السجل
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            $model->calculateBmrAndTdee();
        });
    }

    public function calculateBmrAndTdee()
    {
        if (!$this->gender || !$this->age || !$this->weight || !$this->height) {
            return;
        }

        // 1️⃣ حساب BMR
        if ($this->gender === 'male') {
            $bmr = (10 * $this->weight) + (6.25 * $this->height) - (5 * $this->age) + 5;
        } else {
            $bmr = (10 * $this->weight) + (6.25 * $this->height) - (5 * $this->age) - 161;
        }

        // 2️⃣ معامل النشاط
        $activityFactors = [
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
        ];

        $factor = $activityFactors[$this->activity_level] ?? 1.2;
        $tdee = $bmr * $factor;

        // 3️⃣ السعرات حسب الهدف
        switch ($this->goal) {
            case 'lose_weight':
                $calories = $tdee - 500;
                break;
            case 'gain_weight':
                $calories = $tdee + 500;
                break;
            default:
                $calories = $tdee;
        }

        // حفظ القيم
        $this->bmr = round($bmr);
        $this->tdee = round($calories);
    }
    /**
     * Personality belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
