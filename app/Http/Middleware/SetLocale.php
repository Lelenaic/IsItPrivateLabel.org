<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($sessionLocale = session('locale')) {
            $locale = $sessionLocale;
        } elseif ($cookieLocale = $request->cookie('locale')) {
            $locale = $cookieLocale;
            Session::put('locale', $locale);
        } else {
            $locale = $this->resolveFromAcceptLanguage($request);
        }

        app()->setLocale($locale);
        app()->setFallbackLocale('en');

        return $next($request);
    }

    private function resolveFromAcceptLanguage(Request $request): string
    {
        $acceptLanguage = $request->header('Accept-Language');

        if (! $acceptLanguage) {
            return $this->getDefaultLocale();
        }

        $preferred = $this->parseAcceptLanguage($acceptLanguage);
        $activeLocales = Language::active()->pluck('code')->toArray();

        foreach ($preferred as $locale) {
            if (in_array($locale, $activeLocales)) {
                return $locale;
            }
        }

        return $this->getDefaultLocale();
    }

    private function parseAcceptLanguage(string $header): array
    {
        $languages = [];

        foreach (explode(',', $header) as $part) {
            $segments = explode(';', trim($part));
            $locale = strtolower(trim($segments[0]));

            $quality = 1.0;
            if (isset($segments[1]) && str_starts_with($segments[1], 'q=')) {
                $quality = (float) substr($segments[1], 2);
            }

            $languages[$locale] = $quality;
        }

        arsort($languages);

        $result = [];
        foreach ($languages as $locale => $quality) {
            $result[] = $locale;
            $base = explode('-', $locale)[0];
            if (! in_array($base, $result)) {
                $result[] = $base;
            }
        }

        return array_unique($result);
    }

    private function getDefaultLocale(): string
    {
        $default = Language::default()->first();

        return $default?->code ?? config('app.locale');
    }
}
