<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['language_id', 'content', 'description'])]
class ProofTranslation extends Model
{
    protected function casts(): array
    {
        return [];
    }

    public function proof(): BelongsTo
    {
        return $this->belongsTo(Proof::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
