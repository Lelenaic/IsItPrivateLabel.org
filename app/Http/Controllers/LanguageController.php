<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Language $language, Request $request): RedirectResponse
    {
        abort_unless($language->is_active, 404);

        Session::put('locale', $language->code);

        $response = redirect($request->query('redirect', '/'));
        $response->cookie('locale', $language->code, 60 * 24 * 365);

        return $response;
    }
}
