<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\CoverLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class GenerateCoverLetterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $user_id;
    protected $company;
    protected $position;
    protected $projects;
    protected $version;
    protected $cover_id;
    protected $coverlanguage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $company, $position, $projects, $version,$user_id,$cover_id,$coverlanguage)
    {
        $this->name = $name;
        $this->user_id = $user_id;
        $this->company = $company;
        $this->position = $position;
        $this->projects = $projects;
        $this->version = $version;
        $this->cover_id = $cover_id;
        $this->coverlanguage = $coverlanguage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        // Appeler la fonction generateCoverLetter avec les paramètres fournis
        /* $generatedText = $this->generateCoverLetter($this->name, $this->company, $this->position, $this->version);
        if ($generatedText!="off") {

                $coverLetter = new CoverLetter;
                $coverLetter->user_id = $this->user_id; // Utilisez l'ID de l'utilisateur connecté
                $coverLetter->letter = $generatedText;
                $coverLetter->status = "completed";
                $coverLetter->save();
        } else {
                $coverLetter = new CoverLetter;
                $coverLetter->user_id = Auth::id(); // Utilisez l'ID de l'utilisateur connecté
                $coverLetter->letter = "problem with IA";
                $coverLetter->status = "error";
                $coverLetter->save();
        } */
        try {
            $client = new Client();
            // Clé API OpenAI
            $OPENAI_API_KEY =env('OPENAI_KEY');
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $OPENAI_API_KEY,
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
                            'content' => 'rédige une longue lettre de motivation (plus que 350 mots c\'est important!) (Cover letter) bien rédiger en respectant les structures, en langue:" '.$this->coverlanguage.'", pour l\'envoyer à une entreprise qui cherche un: '.$this->position.'
                            Voila les informations que tu as besoin pour la rédaction:
                            Mon nom complet ( nom et prénom ): "'.$this->name.'". l\'entreprise qui a posé l\'annonce de l\'offre de travail est: "'.$this->company.'", et les projet que j\'ai réalisé ainsi que mes expériences: '.$this->projects.'.
                            la position demandé par l\'entreprise dans son annonce est : "'.$this->position.'"
                                . Rédacte directement la lettre, rien avant et rien après',
                        ],
                    ],
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $body = $response->getBody();
                $data = json_decode($body, true);
                $text = $data['choices'][0]['message']['content'];
                // Supprimer les guillemets triples
                $text = str_replace('"""', '', $text);
                // Supprimer les sauts de ligne
                $text = str_replace("\n", '', $text);
                // Traitement du résultat
                //$coverLetter = CoverLetter::where('id', $this->cover_id)->findOrfail();
                $coverLetter = CoverLetter::where('id', $this->cover_id)->firstOrFail();

                $coverLetter->user_id = $this->user_id; // Utilisez l'ID de l'utilisateur connecté
                $coverLetter->letter = $text;
                $coverLetter->letter_language = $this->coverlanguage;
                $coverLetter->status = "completed";
                $coverLetter->save();
            }
        } catch (GuzzleException $e) {
            $coverLetter = CoverLetter::where('id', $this->cover_id)->firstOrFail();
                $coverLetter->user_id = $this->user_id; // Utilisez l'ID de l'utilisateur connecté
                $coverLetter->letter = $e->getMessage();
                $coverLetter->letter_language = $this->coverlanguage;
                $coverLetter->status = "error";
                $coverLetter->save();
            // Gérer l'erreur comme souhaité
        } catch (\Exception $e) {
            $coverLetter = CoverLetter::where('id', $this->cover_id)->firstOrFail();
                $coverLetter->user_id = $this->user_id; // Utilisez l'ID de l'utilisateur connecté
                $coverLetter->letter_language = $this->coverlanguage;
                $coverLetter->letter = $e->getMessage();
                $coverLetter->status = "error";
                $coverLetter->save();
            // Gérer l'erreur comme souhaité
        }

    }

    /**
     * Generate a cover letter using OpenAI GPT.
     *
     * @param string $name
     * @param string $company
     * @param string $position
     * @param string $version
     * @return string
     */
    private function generateCoverLetter($name, $company, $position, $version)
    {
        // Initialisez un client Guzzle
        $client = new Client();
        // Clé API OpenAI
        $OPENAI_API_KEY =env('OPENAI_KEY');

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $OPENAI_API_KEY,
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
                            'content' => 'rédige une lettre de motivation (Cover letter) en langue: '.$this->coverlanguage.' pour l\'envoyer à une entreprise qui cherche un développeur php expérimenté.
                            Voila les informations que tu as besoin pour la rédaction:
                            Mon nom complet: "'.$name.'", l\'entreprise qu\'il souhaite la rejoindre: "'.$company.'"
                            et la position demandé par l\'entreprise dans son annonce: "'.$position.'"
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
            return $text;


        } catch (RequestException $e) {
            return "off";

        }
    }
}
