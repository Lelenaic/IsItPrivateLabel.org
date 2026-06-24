<?php

namespace App\Http\Resources\Api;

use App\Models\Proof;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<Proof> */
class ProofResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,
            /** Proof category (e.g. "label_match", "packaging", "price_anomaly"). */
            'type' => $this->type,
            /** Translated proof content describing the evidence. */
            'content' => $this->getTranslatedContent($locale),
            /** @var string|null Translated explanation of why this proof matters. */
            'description' => $this->getTranslatedDescription($locale),
        ];
    }
}
