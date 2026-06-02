<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import trait SoftDeletes
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{
    use SoftDeletes; // 2. Aktifkan fitur SoftDeletes di dalam class

    protected $fillable = [
        'user_id',
        'title',
        'title_color',
        'content',
        'drawing_data',
        'images',
        'is_pinned',
        'color',
    ];

    protected $casts = [
        'images'    => 'array',
        'is_pinned' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
