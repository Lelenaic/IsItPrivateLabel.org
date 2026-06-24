<?php

namespace App\Http\Resources\Api;

use App\Models\ProductPricing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<ProductPricing> */
class ProductPricingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /** Pricing type: "resale" (retail price) or "source" (wholesale/manufacturing cost). */
            'type' => $this->type,
            /**
             * Price amount as a decimal number.
             *
             * @var float
             *
             * @example 12.99
             */
            'amount' => (float) $this->amount,
            /** @var string ISO 4217 currency code. @example "USD" */
            'currency' => $this->currency,
            /** @var string|null Additional notes about this price. */
            'comment' => $this->comment,
        ];
    }
}
