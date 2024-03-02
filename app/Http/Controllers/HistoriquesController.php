<?php

namespace App\Http\Controllers;

use App\Models\CoverLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriquesController extends Controller
{
    public function historiqueLanguages()
    {
        return view ('historiqueslanguages');
    }
    public function historiqueCovers(Request $request)
    {
        $userID = Auth::id(); // Récupère l'ID de l'utilisateur connecté
        $cover_id=$request->cover_id;
        //$coverletters = CoverLetter::where('user_id', $userID)->findOrfail();
        //$coverletters = CoverLetter::where('user_id', Auth::id())->findOrFail($cover_id);
        $coverletters = CoverLetter::where('user_id', $userID)->get();


        //return view ('historiquescovers');
        return view('historiquescovers', compact('coverletters'));

    }

}
