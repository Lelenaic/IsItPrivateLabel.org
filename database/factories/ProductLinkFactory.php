<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductLink>
 */
class ProductLinkFactory extends Factory
{
    protected $model = ProductLink::class;

    protected static array $platforms = ['aliexpress', 'made-in-china', 'alibaba', 'company', 'other'];

    public function definition(): array
    {
        $platform = fake()->randomElement(static::$platforms);

        return [
            'product_id' => Product::factory(),
            'url' => match ($platform) {
                'aliexpress' => 'https://www.aliexpress.com/item/' . fake()->numerify('##########') . '.html',
                'made-in-china' => 'https://www.made-in-china.com/products/' . fake()->slug() . '.html',
                'alibaba' => 'https://www.alibaba.com/product-detail/' . fake()->slug() . '.html',
                'company' => fake()->url(),
                default => fake()->url(),
            },
            'platform' => $platform,
            'label' => match ($platform) {
                'aliexpress' => 'View on AliExpress',
                'made-in-china' => 'View on Made-in-China',
                'alibaba' => 'View on Alibaba',
                'company' => 'Company page',
                default => 'View product',
            },
        ];
    }

    public function aliexpress(): static
    {
        return $this->state(fn () => [
            'platform' => 'aliexpress',
            'url' => 'https://www.aliexpress.com/item/' . fake()->numerify('##########') . '.html',
            'label' => 'View on AliExpress',
        ]);
    }

    public function madeInChina(): static
    {
        return $this->state(fn () => [
            'platform' => 'made-in-china',
            'url' => 'https://www.made-in-china.com/products/' . fake()->slug() . '.html',
            'label' => 'View on Made-in-China',
        ]);
    }

    public function alibaba(): static
    {
        return $this->state(fn () => [
            'platform' => 'alibaba',
            'url' => 'https://www.alibaba.com/product-detail/' . fake()->slug() . '.html',
            'label' => 'View on Alibaba',
        ]);
    }
}
