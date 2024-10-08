<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateCoverLetterJob;
use App\Models\CoverLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoversController extends Controller
{
    public function create()
    {
        return view('covers');
    }

    public function GetCover(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'coverlanguage' => 'required|string|max:25',
            'projects' => 'required|string|max:255',

        ]);

        $user = Auth::user();
        if ($user->available_lettres > 0) {

            $coverLetter = new CoverLetter;
            $coverLetter->user_id = Auth::id(); // Utilisez l'ID de l'utilisateur connecté
            $coverLetter->status = "in progress";
            $coverLetter->save();

            /* $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $OPENAI_API_KEY, // Remplacez $OPENAI_API_KEY par votre clé API OpenAI
            ],
            'json' => [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
            [
            'role' => 'system',
            'content' => 'Vous êtes un rédacteur des lettres de motivations',
            ],
            [
            'role' => 'user',
            'content' => 'rédige une lettre de motivation (Cover letter) pour l\'envoyer à une entreprise qui cherche un développeur php expérimenté.
            Voila les informations que tu as besoin pour la rédaction:
            Mon nom complet: "'.$request->name.'", l\'entreprise qu\'il souhaite la rejoindre: "'.$request->company.'"
            et la position demandé par l\'entreprise dans son annonce: "'.$request->position.'"
            . Rédacte directement la lettre, rien avant et rien après',
            ],
            ],
            ],
            ]);
            $body = $response->getBody();
            $data = json_decode($body, true);
            $text = $data['choices'][0]['message']['content'];
            // Supprimer les guillemets triples
            $text = str_replace('"""', '', $text);
            // Supprimer les sauts de ligne
            $text = str_replace("\n", '', $text);
            dd($text); */
            //ici on enregistre dans la table et on envoi le id de l'enregistrement dans le job

            /* $user_id = Auth::id(); */

            GenerateCoverLetterJob::dispatch($validatedData['name'], $validatedData['company'], $validatedData['position'], $validatedData['projects'], 'gpt-3.5-turbo', Auth::id(), $coverLetter->id, $validatedData['coverlanguage']);
            $user->available_lettres -= 1;
            $user->save();
            toastr()->success('Génération en cour');
            return redirect()->route('historiquescovers');
        } else {
            toastr()->error('vous devez acheter un pack');
            return redirect()->back();
        }
    }

    public function checkCoverStatus(Request $request)
    {
        // Récupérer l'identifiant de l'enregistrement à vérifier à partir de la requête AJAX
        $recordId = $request->recordId;
        // Récupérer l'enregistrement correspondant dans la base de données
        $record = CoverLetter::find($recordId);
        $coverLetters = CoverLetter::whereIn('id', $recordId)->get();
        $coverLetterData = [];
        foreach ($coverLetters as $coverLetter) {
            $coverLetterData[$coverLetter->id] = $coverLetter->status;
        }
        return $coverLetterData;

    }

}
