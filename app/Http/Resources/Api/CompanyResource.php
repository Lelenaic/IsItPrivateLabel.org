<?php

namespace App\Http\Resources\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<Company> */
class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            /** The company name. */
            'name' => $this->name,
            /** URL-safe slug identifier. */
            'slug' => $this->slug,
            /** @format uri */
            'website_url' => $this->website_url,
            /** @var string|null Short company description. */
            'description' => $this->description,
        ];
    }
}
