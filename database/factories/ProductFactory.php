<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Language;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(fake()->numberBetween(2, 4), true);

        return [
            'company_id' => Company::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 9999),
            'serial_number' => fake()->optional(0.6)->bothify('??-####-??'),
            'rating' => fake()->numberBetween(0, 10),
            'is_active' => fake()->boolean(90),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    public function translatedIn(string $locale, array $overrides = []): static
    {
        return $this->afterMaking(function (Product $product) use ($locale, $overrides) {
            $language = Language::where('code', $locale)->first();

            if ($language) {
                $product->translations()->create(array_merge([
                    'language_id' => $language->id,
                    'name' => $overrides['name'] ?? $product->name,
                    'description' => $overrides['description'] ?? fake()->sentence(12),
                    'image_path' => $overrides['image_path'] ?? null,
                    'company_url' => $overrides['company_url'] ?? null,
                ], $overrides));
            }
        });
    }
}
