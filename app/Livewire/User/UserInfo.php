<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Personality;

class UserInfo extends Component
{
    public ?int $user_id = null;
    public ?string $gender = null;
    public ?int $age = null;
    public ?float $weight = null;
    public ?float $height = null;
    public ?string $activity_level = 'sedentary';
    public ?string $goal = 'maintain';
    public ?string $diet_type = null;
    public array $allergies = [];
    public array $chronic_diabetes = [];
    public array $health_goals = [];
    public ?string $religion = null;
    public array $custom_preferences = [];
    public array $notifications = [];
    public bool $terms = false;

    protected function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'gender' => 'required|in:male,female',
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'activity_level' => 'required',
            'goal' => 'required|in:maintain,lose_weight,gain_weight',
            'diet_type' => 'nullable|string',
            'allergies' => 'nullable|array',
            'health_goals' => 'nullable|array',
            'chronic_diabetes' => 'nullable|array',
            'religion' => 'nullable|string',
            'custom_preferences' => 'nullable|array',
        ];
    }

    public function mount()
    {
        $this->user_id = $this->user_id ?? Auth::id();

        if ($this->user_id) {
            $p = Personality::where('user_id', $this->user_id)->first();
            if ($p) {
                $this->gender = $p->gender;
                $this->age = $p->age;
                $this->weight = $p->weight;
                $this->height = $p->height;
                $this->activity_level = $p->activity_level;
                $this->goal = $p->goal;
                $this->diet_type = $p->diet_type;
                $this->allergies = $p->allergies ?? [];
                $this->health_goals = $p->health_goals ?? [];
                $this->religion = $p->religion;
                $this->custom_preferences = $p->custom_preferences ?? [];
            }
        }
    }
    public function save() {
        $validated = $this->validate();

        // Normalize arrays and custom preferences
        $validated['allergies'] = Arr::wrap($validated['allergies'] ?? []);
        $validated['health_goals'] = Arr::wrap($validated['health_goals'] ?? []);

        $cp = $validated['custom_preferences'] ?? $this->custom_preferences;
        // normalize likes_spicy to boolean
        $cp['likes_spicy'] = isset($cp['likes_spicy']) ? (bool) $cp['likes_spicy'] : false;
        // parse dislikes_raw into dislikes array if present
        if (isset($cp['dislikes_raw'])) {
            $raw = is_string($cp['dislikes_raw']) ? $cp['dislikes_raw'] : '';
            $cp['dislikes'] = array_values(array_filter(array_map('trim', explode(',', $raw))));
            unset($cp['dislikes_raw']);
        }

        $cp['terms_accepted'] = isset($validated['terms']) ? true : false;

        $validated['custom_preferences'] = $cp;

        Personality::updateOrCreate(
            ['user_id' => $this->user_id],
            $validated
        );
    }

    public function render()
    {
        return view('livewire.user.user-info');
    }
}
