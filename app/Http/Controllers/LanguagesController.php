<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Jobs\GenerateLanguageJob;
use Illuminate\Support\Facades\Auth;

class LanguagesController extends Controller
{
    public function create ()
    {
        return view ('languages');
    }
    public function GetLanguage(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'subject' => 'required|string',
        ]);
        $langArticle = new Language;
            $langArticle->user_id = Auth::id(); // Utilisez l'ID de l'utilisateur connecté
            $langArticle->tcf_ielts = "ielts";
            $langArticle->topic = $validatedData['subject'];
            $langArticle->level = "b2";
            $langArticle->status = "in progress";
            $langArticle->save();

        //ici on enregistre dans la table et on envoi le id de l'enregistrement dans le job

        GenerateLanguageJob::dispatch($validatedData['subject'], 'ielts', 'b2', 'gpt-3.5-turbo',Auth::id(),$langArticle->id);

        // Retourner la réponse ou rediriger vers une autre page avec le résultat
        return redirect()->route('historiqueslanguages');
    }


    public function checkLanguageStatus(Request $request)
    {
        // Récupérer l'identifiant de l'enregistrement à vérifier à partir de la requête AJAX
        $recordId = $request->recordId;
        // Récupérer l'enregistrement correspondant dans la base de données
        $coverLetters = Language::whereIn('id', $recordId)->get();
        $coverLetterData = [];
        foreach ($coverLetters as $coverLetter) {
            $coverLetterData[$coverLetter->id] = $coverLetter->status;
        }
        return $coverLetterData;
    }
}
