<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateLanguageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $topic;
    protected $ielts_tcf;
    protected $level;
    protected $version;
    protected $user_id;
    protected $article_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($topic,$ielts_tcf,$level,$version,$user_id,$article_id)
    {
        $this->topic = $topic;
        $this->ielts_tcf = $ielts_tcf;
        $this->level = $level;
        $this->version = $version;
        $this->user_id = $user_id;
        $this->article_id = $article_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
                            'content' => 'vous etes un connaissant des testes de langues',
                        ],
                        [
                            'role' => 'user',
                            'content' => 'rédige un article pour le sujet "'.$this->topic.'", qui sera accepté dans un exament '.$this->ielts_tcf.', pour un niveau: "'.$this->level.' ',
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
                $article = Language::where('id', $this->article_id)->firstOrFail();
                    $article->article = $text;
                    $article->status = "completed";
                    $article->save();
            }
        } catch (GuzzleException $e) {

                $article = Language::where('id', $this->article_id)->firstOrFail();
                $article->article = $e->getMessage();
                $article->status = "error";
                $article->save();
            // Gérer l'erreur comme souhaité
        } catch (\Exception $e) {
            $article = Language::where('id', $this->article_id)->firstOrFail();
                $article->article = $e->getMessage();
                $article->status = "error";
                $article->save();
            // Gérer l'erreur comme souhaité
        }
    }

    /**
     * Generate a cover letter using OpenAI GPT.
     *
     * @param string $topic
     * @param string $version
     * @return string
     */

}
