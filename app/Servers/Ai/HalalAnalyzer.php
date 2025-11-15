<?php
namespace App\Servers\Ai;

use Prism\Prism\Prism;
use Prism\Prism\Schema\ArraySchema;
use Prism\Prism\Schema\NumberSchema;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\Schema\BooleanSchema;
use Prism\Prism\Enums\Provider;


Class HalalAnalyzer
{
    public function HalalAnalyzerAi(string $photo, string $description)
    {
        $halalAnalyzerSchema = new ObjectSchema(
            name: 'halal_food_analyzer',
            description: 'Analyzer for packaged and fresh foods with strict Halal compliance',
            properties: [
                'common' => new ObjectSchema(
                    name: 'common',
                    description: 'General info shared for analyzer',
                    properties: [
                        'title' => new StringSchema('title', 'Title of product/meal'),
                        'description' => new StringSchema('description', 'Short description'),
                        'brand' => new StringSchema('brand', 'Brand if available'),
                        'ingredients' => new ArraySchema(
                            name: 'ingredients',
                            description: 'List of ingredients',
                            items: new StringSchema('ingredient', 'Ingredient name')
                        ),
                        'nutrition' => new ObjectSchema(
                            name: 'nutrition',
                            description: 'Nutrition facts',
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
                                'vitamins' => new ObjectSchema(name: 'vitamins', description: 'Vitamins (dynamic keys)', additionalProperties: true),
                                'minerals' => new ObjectSchema(name: 'minerals', description: 'Minerals (dynamic keys)', additionalProperties: true),
                            ]
                        ),
                        'health_score' => new NumberSchema('health_score', '0-100'),
                        'personalization_score' => new NumberSchema('personalization_score', '0-100'),
                        'halal_score' => new NumberSchema('halal_score', '0-100'),
                        'personal_advice' => new StringSchema('personal_advice', 'Advice text in user language')
                    ]
                ),
                'specific' => new ObjectSchema(
                    name: 'specific',
                    description: 'Analyzer-specific data including Halal verdict',
                    properties: [
                        'item_type' => new StringSchema('item_type', 'packaged | fresh'),
                        'processing_level' => new StringSchema('processing_level', 'unprocessed | minimally_processed | processed | highly_processed'),
                        'additives' => new ArraySchema(
                            name: 'additives',
                            description: 'Additives / preservatives',
                            items: new ObjectSchema(
                                name: 'additive_item',
                                description: 'Individual additive analysis',
                                properties: [
                                    'name' => new StringSchema('name', 'Additive name'),
                                    'function' => new StringSchema('function', 'Purpose'),
                                    'health_risk' => new StringSchema('health_risk', 'low|medium|high'),
                                    'halal_verdict' => new StringSchema('halal_verdict', 'HALAL | HARAM | SUSPICIOUS')
                                ]
                            )
                        ),
                        'sugar_analysis' => new ObjectSchema(
                            name: 'sugar_analysis',
                            description: 'Sugar content analysis',
                            properties: [
                                'total_sugar_g' => new NumberSchema('total_sugar_g', 'g'),
                                'added_sugar_g' => new NumberSchema('added_sugar_g', 'g'),
                                'risk_level' => new StringSchema('risk_level', 'low|medium|high')
                            ]
                        ),
                        'salt_analysis' => new ObjectSchema(
                            name: 'salt_analysis',
                            description: 'Salt / Sodium content analysis',
                            properties: [
                                'sodium_mg' => new NumberSchema('sodium_mg', 'mg'),
                                'risk_level' => new StringSchema('risk_level', 'low|medium|high')
                            ]
                        ),
                        'improvement_tips' => new ArraySchema(
                            name: 'improvement_tips',
                            description: 'Tips to improve Halal compliance or healthiness',
                            items: new StringSchema('tip', 'Tip text in user language')
                        ),
                        'substitutions' => new ArraySchema(
                            name: 'substitutions',
                            description: 'Recommended substitutions for non-Halal or unhealthy ingredients',
                            items: new StringSchema('sub', 'Substitution text in user language')
                        ),
                        'warnings' => new ArraySchema(
                            name: 'warnings',
                            description: 'User Health or Halal warnings',
                            items: new StringSchema('warning', 'Warning text in user language')
                        ),
                        'cooking_time_minutes' => new NumberSchema('cooking_time_minutes', 'Estimated cooking time'),
                        'recommended_frequency' => new StringSchema('recommended_frequency', 'Recommended consumption frequency'),
                        'halal_certified' => new BooleanSchema('halal_certified', 'true if certified'),
                        'certifier_name' => new StringSchema('certifier_name', 'Name of Halal certifier if available'),
                        'summary_verdict' => new StringSchema('summary_verdict', 'HALAL | HARAM | UNCERTAIN')
                    ]
                )
            ]
        );
        
        $response = Prism::structured()
            ->using(Provider::OpenAI, 'gpt-4o')
            ->withSchema($halalAnalyzerSchema)
            ->withSystemPrompt(view('prompts.analyzer'))
            ->withPrompt('Review the movie Inception')
            ->asStructured();
    }
}
