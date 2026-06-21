<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Proof;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Proof>
 */
class ProofFactory extends Factory
{
    protected $model = Proof::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['text', 'text', 'text', 'link', 'image']);

        return [
            'product_id' => Product::factory(),
            'type' => $type,
            'content' => match ($type) {
                'text' => fake()->paragraph(2),
                'link' => fake()->url(),
                'image' => 'https://placehold.co/600x400/png?text=Proof+Image',
                'file' => '/storage/proofs/sample.pdf',
                default => fake()->sentence(),
            },
            'description' => fake()->optional(0.6)->sentence(6),
        ];
    }

    public function text(string $content = null): static
    {
        return $this->state(fn () => [
            'type' => 'text',
            'content' => $content ?? fake()->paragraph(2),
        ]);
    }

    public function link(string $url = null): static
    {
        return $this->state(fn () => [
            'type' => 'link',
            'content' => $url ?? fake()->url(),
        ]);
    }

    public function image(string $path = null): static
    {
        return $this->state(fn () => [
            'type' => 'image',
            'content' => $path ?? 'https://placehold.co/600x400/png?text=Proof+Image',
        ]);
    }
}
