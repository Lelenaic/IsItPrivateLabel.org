<?php

namespace App\Http\Resources\Api;

use App\Models\ProductLink;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<ProductLink> */
class ProductLinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /** @format uri */
            'url' => $this->url,
            /** @var string|null Platform name (e.g. "amazon", "walmart"). */
            'platform' => $this->platform,
            /** @var string|null Display label for the link. */
            'label' => $this->label,
        ];
    }
}
