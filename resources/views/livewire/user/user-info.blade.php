<div>
    {{-- Do your work, then step back. --}}
    <flux:modal name="profile_info" variant="flyout">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{__("Update profile")}}</flux:heading>
                <flux:text class="mt-2">{{__('Make changes to your personal details.')}}</flux:text>
            </div>
            <form wire:submit.prevent="save" class="space-y-4">
                <input type="hidden" wire:model="user_id" />
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>{{ __('Gender') }}</flux:label>
                        <flux:select wire:model.defer="gender">
                                <option value="">{{ __('Select') }}</option>
                                <option value="male">{{ __('Male') }}</option>
                                <option value="female">{{ __('Female') }}</option>
                        </flux:select>
                        <flux:error name="gender" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Age') }}</flux:label>
                        <flux:input type="number" wire:model.defer="age" min="16" max='90' />
                        <flux:error name="age" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Weight (kg)') }}</flux:label>
                        <flux:input type="number" step="0.1" wire:model.defer="weight" />
                        <flux:error name="weight" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Height (cm)') }}</flux:label>
                        <flux:input type="number" step="0.1" wire:model.defer="height" />
                        <flux:error name="height" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Activity level') }}</flux:label>
                        <flux:select wire:model.defer="activity_level">
                            <option value="sedentary">{{ __('Sedentary') }}</option>
                            <option value="light">{{ __('Light') }}</option>
                            <option value="moderate">{{ __('Moderate') }}</option>
                            <option value="active">{{ __('Active') }}</option>
                            <option value="very_active">{{ __('Very active') }}</option>
                        </flux:select>
                        <flux:error name="activity_level" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Goal') }}</flux:label>
                        <flux:select wire:model.defer="goal">
                            <option value="maintain">{{ __('Maintain') }}</option>
                            <option value="lose_weight">{{ __('Lose weight') }}</option>
                            <option value="gain_weight">{{ __('Gain weight') }}</option>
                        </flux:select>
                        <flux:error name="goal" />
                    </flux:field>
                </div>
                {{-- Diet type as a select with "All" option last. Responsive on mobile. --}}
                <flux:field>
                    <flux:label>{{ __('Diet type') }}</flux:label>
                    <flux:select wire:model.defer="diet_type" class="w-full">
                        <option value="">{{ __('Select diet') }}</option>
                        <option value="omnivore">{{ __('Omnivore') }}</option>
                        <option value="vegetarian">{{ __('Vegetarian') }}</option>
                        <option value="vegan">{{ __('Vegan') }}</option>
                        <option value="pescatarian">{{ __('Pescatarian') }}</option>
                        <option value="keto">{{ __('Keto') }}</option>
                        <option value="paleo">{{ __('Paleo') }}</option>
                        <option value="all">{{ __('All') }}</option>
                    </flux:select>
                    <flux:error name="diet_type" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('Allergies') }}</flux:label>
                    <flux:checkbox.group wire:model.defer="allergies" class="mt-2">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2">
                            <flux:checkbox label="{{ __('Gluten') }}" value="gluten" />
                            <flux:checkbox label="{{ __('Peanuts') }}" value="peanuts" />
                            <flux:checkbox label="{{ __('Dairy') }}" value="dairy" />
                            <flux:checkbox label="{{ __('Soy') }}" value="soy" />
                            <flux:checkbox label="{{ __('Eggs') }}" value="eggs" />
                            <flux:checkbox label="{{ __('Tree Nuts') }}" value="treenuts" />
                            <flux:checkbox label="{{ __('Sesame') }}" value="sesame" />
                            <flux:checkbox label="{{ __('Fish') }}" value="fish" />
                        </div>
                    </flux:checkbox.group>
                    <flux:error name="allergies" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('Health goals') }}</flux:label>
                    <flux:checkbox.group wire:model.defer="health_goals" class="mt-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                            <flux:checkbox label="{{ __('Build muscle') }}" value="build_muscle" />
                            <flux:checkbox label="{{ __('Lose fat') }}" value="lose_fat" />
                            <flux:checkbox label="{{ __('Improve endurance') }}" value="improve_endurance" />
                            <flux:checkbox label="{{ __('Improve sleep') }}" value="improve_sleep" />
                        </div>
                    </flux:checkbox.group>
                    <flux:error name="health_goals" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('Chronic Diabetes') }}</flux:label>
                    <flux:checkbox.group wire:model.defer="chronic_diabetes" class="mt-2">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                            <flux:checkbox label="{{ __('Diabetes') }}" value="diabetes" />
                            <flux:checkbox label="{{ __('Hypertension') }}" value="hypertension" />
                            <flux:checkbox label="{{ __('High Cholesterol') }}" value="high_cholesterol" />
                        </div>
                    </flux:checkbox.group>
                    <flux:error name="health_goals" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('Religion') }}</flux:label>
                    <flux:switch placeholder="{{ __('Optional') }}" wire:model.defer="religion" />
                    <flux:error name="religion" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Custom preferences') }}</flux:label>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <flux:field>
                            <flux:label>{{ __('Likes spicy') }}</flux:label>
                            <flux:checkbox wire:model.defer="custom_preferences.likes_spicy" value="1" />
                        </flux:field>

                        <flux:field>
                            <flux:label>{{ __('Dislikes (comma separated)') }}</flux:label>
                            <flux:input placeholder="{{ __('e.g. onion,garlic') }}" wire:model.defer="custom_preferences.dislikes_raw" />
                            <flux:error name="custom_preferences.dislikes_raw" />
                        </flux:field>
                    </div>
                    <flux:error name="custom_preferences" />
                </flux:field>

                {{-- Terms inline field --}}
                <flux:field variant="inline">
                    <flux:checkbox wire:model.defer="terms" />
                    <flux:label>{{ __('I agree to the terms and conditions') }}</flux:label>
                    <flux:error name="terms" />
                </flux:field>

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">{{ __('Save changes') }}</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
