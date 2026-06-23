<?php

namespace App\Http\Middleware;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'locale' => app()->getLocale(),
            'translations' => $this->getTranslations(app()->getLocale()),
            'languages' => Language::active()->select('code', 'name')->get(),
        ];
    }

    private function getTranslations(string $locale): array
    {
        return Cache::remember("translations.{$locale}", 3600, fn () => Translation::whereHas('language', fn ($q) => $q->where('code', $locale))
            ->get()
            ->mapWithKeys(fn ($t) => ["{$t->group_name}.{$t->key}" => $t->value])
            ->toArray()
        );
    }
}
