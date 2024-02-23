<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoriquesController extends Controller
{
    public function historiqueLanguages()
    {
        return view ('historiqueslanguages');
    }
    public function historiqueCovers()
    {
        return view ('historiquescovers');

    }

}
