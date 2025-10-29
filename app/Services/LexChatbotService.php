<?php

namespace App\Services;

use Aws\LexRuntimeV2\LexRuntimeV2Client;
use Illuminate\Support\Facades\Log;

class LexChatbotService
{
    protected $client;
    protected $botId;
    protected $botAliasId;
    protected $localeId;

    public function __construct()
    {
        $this->client = new LexRuntimeV2Client([
            'version' => 'latest',
            'region' => config('services.aws.region', 'us-east-1'),
            'credentials' => [
                'key' => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ],
        ]);

        $this->botId = config('services.lex.bot_id');
        $this->botAliasId = config('services.lex.bot_alias_id');
        $this->localeId = config('services.lex.locale_id', 'es_ES');
    }

    public function sendMessage(string $message, string $sessionId)
    {
        try {
            $result = $this->client->recognizeText([
                'botId' => $this->botId,
                'botAliasId' => $this->botAliasId,
                'localeId' => $this->localeId,
                'sessionId' => $sessionId,
                'text' => $message,
            ]);

            return [
                'success' => true,
                'messages' => $result['messages'] ?? [],
                'sessionState' => $result['sessionState'] ?? [],
            ];
        } catch (\Exception $e) {
            Log::error('Lex Chatbot Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Error al procesar el mensaje',
            ];
        }
    }
}
