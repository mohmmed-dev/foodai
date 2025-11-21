<?php
namespace App\Servers\Ai;

use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\ArraySchema;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\Schema\BooleanSchema;
use Prism\Prism\ValueObjects\Media\Image;


Class HalalCreator
{
    public static function HalalCreatorAI($title = null , $image_path = null)
    {
        $halalCreatorSchema = new ObjectSchema(
            name: 'halal_recipe_creator',
            description: 'Personalized recipe creator AI with strict Halal compliance and health-based recommendations',
            properties: [
                'common' => new ObjectSchema(
                    name: 'common',
                    description: 'General information common to all recipes',
                    properties: [
                        'title' => new StringSchema('title', 'Name of the recipe or product'),
                        'description' => new StringSchema('description', 'Brief description of the recipe or product'),
                        'brand' => new StringSchema('brand', 'Brand if applicable, null if none'),
                        'ingredients' => new ArraySchema(
                            name: 'ingredients',
                            description: 'List of ingredients for the recipe',
                            items: new StringSchema('ingredient', 'Ingredient name')
                        ),
                        'nutrition' => new ObjectSchema(
                            name: 'nutrition',
                            description: 'Nutrition facts for the recipe',
                            properties: [
                                'calories' => new NumberSchema('calories', 'Total kcal'),
                                'macros' => new ObjectSchema(
                                    name: 'macros',
                                    description: 'Macronutrients',
                                    properties: [
                                        'protein' => new NumberSchema('protein', 'grams'),
                                        'carbs' => new NumberSchema('carbs', 'grams'),
                                        'fat' => new NumberSchema('fat', 'grams'),
                                    ]
                                ),
                                'vitamins' => new StringSchema(name: 'vitamins', description: 'Vitamins (dynamic keys)'),
                                'minerals' => new StringSchema(name: 'minerals', description: 'Minerals (dynamic keys)'),
                                // 'vitamins' => new ObjectSchema(name: 'vitamins', description: 'Vitamins (dynamic keys)'),
                                // 'minerals' => new ObjectSchema(name: 'minerals', description: 'Minerals (dynamic keys)'),

                            ]
                        ),
                        'health_score' => new NumberSchema('health_score', '0-100, personalized health score based on user profile'),
                        'personalization_score' => new NumberSchema('personalization_score', '0-100, match with user goals and preferences'),
                        'halal_score' => new NumberSchema('halal_score', '0-100, how compliant the recipe is with Halal rules'),
                        'personal_advice' => new StringSchema('personal_advice', 'Personalized advice based on user health, goals, and allergies')
                    ]
                ),
                'specific' => new ObjectSchema(
                    name: 'specific',
                    description: 'Creator-specific data including recipe suggestions and Halal analysis',
                    properties: [
                        'input_type' => new StringSchema('input_type', '"available_items" or "user_request"'),
                        'recipe_suggestions' => new ArraySchema(
                            name: 'recipe_suggestions',
                            description: 'Suggested recipes based on input type',
                            items: new ObjectSchema(
                                name: 'recipe_item',
                                description: 'Individual recipe suggestion with detailed info',
                                properties: [
                                    'name' => new StringSchema('name', 'Recipe name'),
                                    'ingredients' => new ArraySchema('ingredients', 'Ingredients list', new StringSchema('ingredient', 'Ingredient name')),
                                    'instructions' => new ArraySchema('instructions', 'Step-by-step instructions', new StringSchema('step', 'Instruction step')),
                                    'estimated_time_minutes' => new NumberSchema('estimated_time_minutes', 'Estimated cooking time in minutes'),
                                    'nutrition' => new ObjectSchema(
                                        name: 'nutrition',
                                        description: 'Nutrition info for the recipe',
                                        properties: [
                                            'calories' => new NumberSchema('calories', 'kcal'),
                                            'macros' => new ObjectSchema(
                                                name: 'macros',
                                                description: 'Protein / Carbs / Fat',
                                                properties: [
                                                    'protein' => new NumberSchema('protein', 'grams'),
                                                    'carbs' => new NumberSchema('carbs', 'grams'),
                                                    'fat' => new NumberSchema('fat', 'grams'),
                                                ]
                                            ),
                                            'vitamins' => new StringSchema(name: 'vitamins', description: 'Vitamins (dynamic keys)'),
                                            'minerals' => new StringSchema(name: 'minerals', description: 'Minerals (dynamic keys)'),
                                        ]
                                    ),
                                    'personal_advice' => new StringSchema('personal_advice', 'Advice specific to this recipe for the user'),
                                    'improvement_tips' => new ArraySchema('improvement_tips', 'Tips to make recipe healthier or tastier', new StringSchema('tip', 'Tip text')),
                                    'substitutions' => new ArraySchema('substitutions', 'Ingredient substitutions based on user needs', new StringSchema('sub', 'Substitution text')),
                                    'warnings' => new ArraySchema('warnings', 'Health or allergy warnings', new StringSchema('warning', 'Warning text')),
                                    'cooking_time_minutes' => new NumberSchema('cooking_time_minutes', 'Estimated total cooking time'),
                                    'recommended_frequency' => new StringSchema('recommended_frequency', 'Suggested frequency for consuming this recipe'),
                                    'halal_certified' => new BooleanSchema('halal_certified', 'True if officially Halal certified'),
                                    'certifier_name' => new StringSchema('certifier_name', 'Name of Halal certification authority if available'),
                                    'summary_verdict' => new StringSchema('summary_verdict', 'HALAL | HARAM | UNCERTAIN based on ingredient analysis')
                                ]
                            )
                        )
                    ]
                )
            ]
        );
         // Prepare Image If Available
        if($image_path) {
            $imagePath = [Image::fromLocalPath(storage_path('app/public/photos/'.$image_path))];
        } else {
            $imagePath = null;
        }

        $response = Prism::structured()
            ->using(Provider::Gemini, 'gemini-2.0-flash')
            ->withSchema($halalCreatorSchema)
            ->withSystemPrompt(view('prompts.analyzer'))
            ->withPrompt('',$imagePath)
            ->withClientOptions(['timeout' => 90])
            ->asStructured();

                


        return $response->structured;
    }
}
