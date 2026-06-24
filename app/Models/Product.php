<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

#[Fillable(['name', 'slug', 'serial_number', 'rating', 'company_id', 'is_active'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, Searchable;

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function links(): HasMany
    {
        return $this->hasMany(ProductLink::class);
    }

    public function proofs(): HasMany
    {
        return $this->hasMany(Proof::class);
    }

    public function pricings(): HasMany
    {
        return $this->hasMany(ProductPricing::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translatedIn(string $locale): HasMany
    {
        return $this->translations()->whereHas('language', fn ($q) => $q->where('code', $locale));
    }

    public function getTranslationFor(?string $locale = null): ?ProductTranslation
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

    public function getTranslatedName(?string $locale = null): string
    {
        $translation = $this->getTranslationFor($locale);

        return $translation?->name ?? $this->name;
    }

    public function getTranslatedDescription(?string $locale = null): ?string
    {
        $translation = $this->getTranslationFor($locale);

        return $translation?->description;
    }

    public function getTranslatedImagePath(?string $locale = null): ?string
    {
        $translation = $this->getTranslationFor($locale);

        return $translation?->image_path;
    }

    public function getTranslatedCompanyUrl(?string $locale = null): ?string
    {
        $translation = $this->getTranslationFor($locale);

        return $translation?->company_url;
    }

    public function isAvailableInLocale(?string $locale = null): bool
    {
        $locale ??= app()->getLocale();

        return $this->translations->contains(
            fn ($t) => $t->language?->code === $locale,
        );
    }

    public function shouldBeSearchable(): bool
    {
        return $this->is_active;
    }

    public function toSearchableArray(): array
    {
        $allNames = collect([$this->name])
            ->merge($this->translations->pluck('name'))
            ->filter()
            ->implode(' ');

        return [
            'name' => $allNames,
            'serial_number' => (string) ($this->serial_number ?? ''),
            'rating' => $this->rating,
            'company_name' => $this->company?->name ?? '',
            'is_active' => $this->is_active,
        ];
    }

    public function searchableAs(): string
    {
        return 'products';
    }

    public function newSearchQuery(): Builder
    {
        return $this->newQuery()->with('translations');
    }
}
