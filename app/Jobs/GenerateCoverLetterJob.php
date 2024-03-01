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
        $OPENAI_API_KEY =env('OPENAI_KEY');

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
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


        } catch (RequestException $e) {

        }
    }
}
