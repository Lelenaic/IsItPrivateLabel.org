<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class OurMissionController extends Controller
{
    public function index()
    {
        return Inertia::render('OurMission');
    }
}
