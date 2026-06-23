<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['language_id', 'group_name', 'key', 'value'])]
class Translation extends Model
{
    protected function casts(): array
    {
        return [];
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
