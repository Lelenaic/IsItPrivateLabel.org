<?php

namespace App\Http\Resources\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<Product> */
class ProductDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            /** The product's default name. */
            'name' => $this->name,
            /** @var string URL-safe unique slug, used as the public identifier. */
            'slug' => $this->slug,
            /** @var string|null Manufacturer serial or model number. */
            'serial_number' => $this->serial_number,
            /**
             * Private label score from 0 (likely not private label) to 10 (confirmed private label).
             *
             * @example 8
             */
            'rating' => $this->rating,
            /** Whether this product is publicly visible. */
            'is_active' => $this->is_active,
            /** The company that owns this product. */
            'company' => new CompanyResource($this->whenLoaded('company')),
            /** All available translations for this product across languages. */
            'translations' => ProductTranslationResource::collection($this->whenLoaded('translations')),
            /** External links related to this product (retailers, reviews, etc.). */
            'links' => ProductLinkResource::collection($this->whenLoaded('links')),
            /** Price data from various sources. */
            'pricings' => ProductPricingResource::collection($this->whenLoaded('pricings')),
            /**
             * Evidence supporting the private label rating.
             * Only includes proofs visible in the current locale.
             */
            'proofs' => ProofResource::collection(
                $this->whenLoaded('proofs')->filter(
                    fn ($proof) => $proof->isVisibleInLocale($locale)
                )->values()
            ),
            /** @format date-time */
            'created_at' => $this->created_at,
            /** @format date-time */
            'updated_at' => $this->updated_at,
        ];
    }
}
