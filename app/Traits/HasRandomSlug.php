<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasRandomSlug
{
    protected static function bootHasRandomSlug()
    {
        static::creating(function ($model) {
            $model->slug = static::generateUniqueSlug($model);
        });
    }

    protected static function generateUniqueSlug($model)
    {
        do {
            $slug = Str::random(15);
        } while ($model->where('slug', $slug)->exists());

        return $slug;
    }
}
