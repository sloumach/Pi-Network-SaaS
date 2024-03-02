<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\CoverLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriquesController extends Controller
{
    public function historiqueLanguages()
    {
        $userID = Auth::id(); // Récupère l'ID de l'utilisateur connecté
        $articles = Language::where('user_id', $userID)->get();
        $type ='lang';
        return view ('historiqueslanguages',compact('articles','type'));
    }
    public function historiqueCovers(Request $request)
    {
        $userID = Auth::id(); // Récupère l'ID de l'utilisateur connecté

        //$coverletters = CoverLetter::where('user_id', $userID)->findOrfail();
        //$coverletters = CoverLetter::where('user_id', Auth::id())->findOrFail($cover_id);
        $coverletters = CoverLetter::where('user_id', $userID)->get();
        $type ='cover';

        //return view ('historiquescovers');
        return view('historiquescovers', compact('coverletters','type'));

    }

}
