<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Content extends Model
{
    /** @use HasFactory<\Database\Factories\ContentFactory> */
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'type',
        'share',
        'error',
        'self',
    ];

    /**
     * Attribute casts.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'body' => 'array',
        'share' => 'boolean',
        'error' => 'boolean',
        'self' => 'boolean',
    ];

    /**
     * Content belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
