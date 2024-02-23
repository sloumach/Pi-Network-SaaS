<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GenerateCoverLetterJob;

class CoversController extends Controller
{
    public function create()
    {
        return view ('covers');
    }

    public function GetCover(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);
        $version="model de gpt";
        //ici on enregistre dans la table et on envoi le id de l'enregistrement dans le job

        GenerateCoverLetterJob::dispatch($validatedData['name'], $validatedData['company'], $validatedData['position'], $version);

        // Retourner la réponse ou rediriger vers une autre page avec le résultat
        return redirect()->route('historiquescovers');
    }


    public function checkCoverStatus(Request $request)
    {
        // Récupérer l'identifiant de l'enregistrement à vérifier à partir de la requête AJAX
        $recordId = $request->input('recordId');

        // Récupérer l'enregistrement correspondant dans la base de données
        $record = Exemple::find($recordId);

        // Vérifier l'état de l'enregistrement et renvoyer la réponse appropriée
        if ($record) {
            return response()->json($record->status); // Supposons que le statut est stocké dans une colonne "status"
        } else {
            return response()->json("not_found"); // Retourner "not_found" si l'enregistrement n'est pas trouvé
        }
    }

}
