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

    public function getCover(Request $request)
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

    private function generateCoverLetter($name, $company, $position)
    {
        // Initialisez un client Guzzle
        $client = new Client();

        // Clé API OpenAI
        $apiKey = 'VOTRE_CLE_API_OPENAI';

        // Corps de la requête à envoyer à l'API GPT de OpenAI
        $requestData = [
            'prompt' => "Dear Hiring Manager,\n\nI am writing to apply for the position of $position at $company. My name is $name and I am excited to bring my skills and experience to your team.\n\nSincerely,\n$name",
            'model' => $version, // Spécifiez la version du modèle ici
        ];

        // Exemple d'appel à l'API GPT de OpenAI avec Guzzle
        $response = $client->post('https://api.openai.com/v1/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $requestData,
        ]);

        // Traitement de la réponse de l'API
        $responseBody = json_decode($response->getBody(), true); // Convertir la réponse JSON en tableau associatif
        $generatedText = $responseBody['choices'][0]['text']; // Extraire le texte généré par l'API

        return $generatedText;
    }
    public function checkRecordStatus(Request $request)
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
