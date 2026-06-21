<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

#[Fillable(['name', 'slug', 'description', 'image_path', 'serial_number', 'rating', 'company_url'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, Searchable;

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
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

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'serial_number' => $this->serial_number,
            'rating' => $this->rating,
            'company_name' => $this->company?->name,
        ];
    }

    public function searchableAs(): string
    {
        return 'products';
    }
}
