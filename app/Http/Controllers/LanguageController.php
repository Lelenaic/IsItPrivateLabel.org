<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Language $language): RedirectResponse
    {
        abort_unless($language->is_active, 404);

        Session::put('locale', $language->code);

        return redirect()->intended('/');
    }
}
