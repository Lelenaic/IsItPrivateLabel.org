<?php

namespace App\Http\Resources\Api;

use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<ProductTranslation> */
class ProductTranslationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /** Translated product name. */
            'name' => $this->name,
            /** @var string|null Translated product description. */
            'description' => $this->description,
            /** @var string|null Path to the translated product image. */
            'image_path' => $this->image_path,
            /** @var string|null URL to the product on the company's website. */
            'company_url' => $this->company_url,
            /** The language this translation is in. */
            'language' => [
                /** ISO 639-1 language code (e.g. "en", "fr"). */
                'code' => $this->language->code,
                /** Human-readable language name (e.g. "English", "French"). */
                'name' => $this->language->name,
            ],
        ];
    }
}
