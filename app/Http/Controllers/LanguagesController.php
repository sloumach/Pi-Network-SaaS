<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateLanguageJob;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguagesController extends Controller
{
    public function create()
    {
        return view('languages');
    }
    public function GetLanguage(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'exam' => 'required|string',
            'level' => 'required|string',
        ]);
        $user = Auth::user();
        if ($validatedData['exam'] == 1) {

            if ($user->available_tcf > 0) {
                $langArticle = new Language;
                $langArticle->user_id = Auth::id(); // Utilisez l'ID de l'utilisateur connecté
                $langArticle->tcf_ielts = "TCF";
                $langArticle->topic = $validatedData['subject'];
                $langArticle->level = $validatedData['level'];
                $langArticle->status = "in progress";
                $langArticle->save();

                //ici on enregistre dans la table et on envoi le id de l'enregistrement dans le job

                GenerateLanguageJob::dispatch($validatedData['subject'], 'ielts', $validatedData['level'], 'gpt-3.5-turbo', Auth::id(), $langArticle->id);

                $user->available_tcf -= 1;
                $user->save();
                toastr()->success('Génération en cours');
                return redirect()->route('historiqueslanguages');
            } else {
                toastr()->error('vous devez acheter un pack');

                return redirect()->back();
            }
        }
        if ($validatedData['exam'] == 2) {
            if ($user->available_ielts > 0) {
                $langArticle = new Language;
                $langArticle->user_id = Auth::id(); // Utilisez l'ID de l'utilisateur connecté
                $langArticle->tcf_ielts = "IELTS";
                $langArticle->topic = $validatedData['subject'];
                $langArticle->level = $validatedData['level'];
                $langArticle->status = "in progress";
                $langArticle->save();

                //ici on enregistre dans la table et on envoi le id de l'enregistrement dans le job

                GenerateLanguageJob::dispatch($validatedData['subject'], 'ielts', $validatedData['level'], 'gpt-3.5-turbo', Auth::id(), $langArticle->id);

                $user->available_ielts -= 1;
                $user->save();
                toastr()->success('Génération en cours');
                return redirect()->route('historiqueslanguages');
            } else {
                toastr()->error('vous devez acheter un pack');
                return redirect()->back();
            }
        }
        abort(404, "plan not found");
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
