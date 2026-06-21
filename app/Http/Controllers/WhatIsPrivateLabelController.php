<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class WhatIsPrivateLabelController extends Controller
{
    public function index()
    {
        return Inertia::render('WhatIsPrivateLabel');
    }
}
