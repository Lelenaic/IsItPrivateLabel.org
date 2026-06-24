<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'lenaic@lenaic.me',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        DB::table('languages')->insert([
            [
                'code' => 'fr',
                'name' => 'French',
                'is_active' => true,
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

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
        $englishId = DB::table('languages')->where('code', 'en')->value('id');
        $frenchId = DB::table('languages')->where('code', 'fr')->value('id');

        $companies->each(function (Company $company) use ($proofTypes, $platforms, $englishId, $frenchId) {
            $productCount = fake()->numberBetween(2, 5);

            for ($i = 0; $i < $productCount; $i++) {
                $name = fake()->words(fake()->numberBetween(2, 4), true);
                $name = ucfirst($name);

                $product = $company->products()->create([
                    'name' => $name,
                    'slug' => fake()->unique()->slug(3),
                    'serial_number' => strtoupper(fake()->bothify('??-####-??')),
                    'rating' => fake()->numberBetween(1, 10),
                    'is_active' => true,
                ]);

                $companyUrl = $company->website_url ? $company->website_url.'/products/'.fake()->slug() : null;
                $imagePath = 'https://placehold.co/600x400/png?text='.urlencode($name);

                $product->translations()->create([
                    'language_id' => $englishId,
                    'name' => $name,
                    'description' => fake()->paragraph(2),
                    'image_path' => $imagePath,
                    'company_url' => $companyUrl,
                ]);

                if (fake()->boolean(30)) {
                    $product->translations()->create([
                        'language_id' => $frenchId,
                        'name' => fake()->words(fake()->numberBetween(2, 4), true),
                        'description' => fake()->paragraph(2),
                        'image_path' => $imagePath,
                        'company_url' => $companyUrl,
                    ]);
                }

                if (fake()->boolean(40)) {
                    $product->pricings()->create([
                        'type' => 'resale',
                        'amount' => fake()->randomFloat(2, 10, 80),
                        'currency' => 'USD',
                        'comment' => null,
                    ]);

                    $product->pricings()->create([
                        'type' => 'source',
                        'amount' => fake()->randomFloat(2, 3, 30),
                        'currency' => 'CNY',
                        'comment' => 'Source price from supplier',
                    ]);

                    if (fake()->boolean(30)) {
                        $product->pricings()->create([
                            'type' => 'source',
                            'amount' => fake()->randomFloat(2, 5, 50),
                            'currency' => 'EUR',
                            'comment' => 'European supplier',
                        ]);
                    }
                }

                $proofCount = fake()->numberBetween(1, 4);
                for ($j = 0; $j < $proofCount; $j++) {
                    $type = fake()->randomElement($proofTypes);

                    $proof = $product->proofs()->create([
                        'type' => $type,
                        'content' => match ($type) {
                            'text' => fake()->paragraph(2),
                            'link' => 'https://www.'.fake()->randomElement($platforms).'.com/'.fake()->slug(4),
                            'image' => 'https://placehold.co/600x400/png?text=Proof+Image',
                        },
                        'description' => fake()->sentence(4),
                        'show_in_all_languages' => fake()->boolean(70),
                    ]);

                    if (fake()->boolean(25)) {
                        $proof->translations()->create([
                            'language_id' => $frenchId,
                            'content' => match ($type) {
                                'text' => fake()->paragraph(2),
                                'link' => 'https://www.'.fake()->randomElement($platforms).'.com/'.fake()->slug(4),
                                'image' => 'https://placehold.co/600x400/png?text=Proof+Image',
                            },
                            'description' => fake()->sentence(4),
                        ]);

                        if (! $proof->show_in_all_languages) {
                            $proof->visibleInLanguages()->attach($frenchId);
                        }
                    }
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
