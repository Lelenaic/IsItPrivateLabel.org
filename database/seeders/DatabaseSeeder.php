<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $companies = collect();

        for ($i = 0; $i < 10; $i++) {
            $companies->push(Company::create([
                'name' => fake()->unique()->company(),
                'website_url' => fake()->url(),
                'description' => fake()->paragraph(2),
            ]));
        }

        $proofTypes = ['text', 'link', 'image'];
        $platforms = ['aliexpress', 'alibaba', 'made-in-china'];

        $companies->each(function (Company $company) use ($proofTypes, $platforms) {
            $productCount = fake()->numberBetween(2, 5);

            for ($i = 0; $i < $productCount; $i++) {
                $name = fake()->words(fake()->numberBetween(2, 4), true);
                $name = ucfirst($name);

                $product = $company->products()->create([
                    'name' => $name,
                    'slug' => fake()->unique()->slug(3),
                    'description' => fake()->paragraph(2),
                    'image_path' => 'https://placehold.co/600x400/png?text='.urlencode($name),
                    'serial_number' => strtoupper(fake()->bothify('??-####-??')),
                    'rating' => fake()->numberBetween(1, 10),
                    'company_url' => $company->website_url ? $company->website_url.'/products/'.fake()->slug() : null,
                ]);

                $proofCount = fake()->numberBetween(1, 4);
                for ($j = 0; $j < $proofCount; $j++) {
                    $type = fake()->randomElement($proofTypes);

                    $product->proofs()->create([
                        'type' => $type,
                        'content' => match ($type) {
                            'text' => fake()->paragraph(2),
                            'link' => 'https://www.'.fake()->randomElement($platforms).'.com/'.fake()->slug(4),
                            'image' => 'https://placehold.co/600x400/png?text=Proof+Image',
                        },
                        'description' => fake()->sentence(4),
                    ]);
                }

                $linkCount = fake()->numberBetween(0, 3);
                $selectedPlatforms = fake()->randomElements($platforms, $linkCount);

                foreach ($selectedPlatforms as $platform) {
                    $product->links()->create([
                        'url' => match ($platform) {
                            'aliexpress' => 'https://www.aliexpress.com/item/'.fake()->numerify('##########').'.html',
                            'alibaba' => 'https://www.alibaba.com/product-detail/'.fake()->slug(3).'.html',
                            'made-in-china' => 'https://www.made-in-china.com/products/'.fake()->slug(3).'.html',
                        },
                        'platform' => $platform,
                        'label' => match ($platform) {
                            'aliexpress' => 'View on AliExpress',
                            'alibaba' => 'View on Alibaba',
                            'made-in-china' => 'View on Made-in-China',
                        },
                    ]);
                }
            }
        });

        Product::factory()->count(2000)->sequence(fn () => [
            'company_id' => $companies->random()->id,
        ])->create();

        Artisan::call('scout:import', ['model' => Product::class]);
    }
}
