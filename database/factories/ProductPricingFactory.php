<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductPricing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductPricing>
 */
class ProductPricingFactory extends Factory
{
    protected $model = ProductPricing::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'type' => fake()->randomElement(['resale', 'source']),
            'amount' => fake()->randomFloat(2, 5, 50),
            'currency' => fake()->randomElement(['USD', 'EUR', 'CNY']),
            'comment' => fake()->optional(0.3)->sentence(4),
        ];
    }

    public function resale(): static
    {
        return $this->state(fn () => ['type' => 'resale']);
    }

    public function source(): static
    {
        return $this->state(fn () => ['type' => 'source']);
    }

    public function withCurrency(string $currency): static
    {
        return $this->state(fn () => ['currency' => $currency]);
    }
}
