<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class GenerateCoverLetterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $company;
    protected $position;
    protected $version;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $company, $position, $version)
    {
        $this->name = $name;
        $this->company = $company;
        $this->position = $position;
        $this->version = $version;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Appeler la fonction generateCoverLetter avec les paramètres fournis
        $generatedText = $this->generateCoverLetter($this->name, $this->company, $this->position, $this->version);

        // Faire ce que vous voulez avec le texte généré, comme l'enregistrer dans la base de données, l'envoyer par email, etc.
        // Par exemple, si vous voulez enregistrer le texte généré dans la base de données, vous pouvez faire quelque chose comme ça :
        // Model::create(['generated_text' => $generatedText]);
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
        $apiKey = 'VOTRE_CLE_API_OPENAI';

        // Corps de la requête à envoyer à l'API GPT de OpenAI
        $requestData = [
            'prompt' => "Dear Hiring Manager,\n\nI am writing to apply for the position of $position at $company. My name is $name and I am excited to bring my skills and experience to your team.\n\nSincerely,\n$name",
            'model' => $version, // Spécifiez la version du modèle ici
        ];
        try {
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

        } catch (RequestException $e) {

        }
    }
}
