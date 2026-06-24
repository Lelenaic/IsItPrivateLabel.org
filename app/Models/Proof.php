<?php

namespace App\Models;

use Database\Factories\ProofFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['type', 'content', 'description', 'show_in_all_languages'])]
class Proof extends Model
{
    /** @use HasFactory<ProofFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'show_in_all_languages' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProofTranslation::class);
    }

    public function visibleInLanguages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'proof_languages');
    }

    public function getTranslationFor(?string $locale = null): ?ProofTranslation
    {
        $locale ??= app()->getLocale();

        $translation = $this->translations->first(
            fn ($t) => $t->language?->code === $locale,
        );

        if ($translation) {
            return $translation;
        }

        $defaultTranslation = $this->translations->first(
            fn ($t) => $t->language?->is_default,
        );

        if ($defaultTranslation) {
            return $defaultTranslation;
        }

        return $this->translations->sortBy('id')->first();
    }

    public function getTranslatedContent(?string $locale = null): string
    {
        $translation = $this->getTranslationFor($locale);

        return $translation?->content ?? $this->content;
    }

    public function getTranslatedDescription(?string $locale = null): ?string
    {
        $translation = $this->getTranslationFor($locale);

        return $translation?->description ?? $this->description;
    }

    public function isVisibleInLocale(?string $locale = null): bool
    {
        $locale ??= app()->getLocale();

        if ($this->show_in_all_languages) {
            return true;
        }

        return $this->visibleInLanguages->contains('code', $locale);
    }
}
