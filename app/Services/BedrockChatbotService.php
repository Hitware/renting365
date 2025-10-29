<?php

namespace App\Services;

use Aws\BedrockRuntime\BedrockRuntimeClient;
use Illuminate\Support\Facades\Log;

class BedrockChatbotService
{
    protected $client;
    protected $modelId = 'anthropic.claude-3-haiku-20240307-v1:0';

    public function __construct()
    {
        $this->client = new BedrockRuntimeClient([
            'version' => 'latest',
            'region' => config('services.aws.region', 'us-east-1'),
            'credentials' => [
                'key' => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ],
        ]);
    }

    public function sendMessage(string $message): array
    {
        $systemPrompt = $this->getSystemPrompt();

        try {
            $payload = [
                'anthropic_version' => 'bedrock-2023-05-31',
                'max_tokens' => 1000,
                'system' => $systemPrompt,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ]
            ];

            $result = $this->client->invokeModel([
                'modelId' => $this->modelId,
                'contentType' => 'application/json',
                'accept' => 'application/json',
                'body' => json_encode($payload)
            ]);

            $response = json_decode($result['body'], true);
            $responseText = $response['content'][0]['text'] ?? 'Lo siento, no pude procesar tu mensaje.';

            return [
                'success' => true,
                'message' => $responseText
            ];
        } catch (\Exception $e) {
            Log::error('Bedrock Chatbot Error: ' . $e->getMessage());
            
            return $this->getFallbackResponse($message);
        }
    }

    protected function getSystemPrompt(): string
    {
        return "Eres un asistente virtual de Renting365, una empresa de renting de motos en Colombia. Tu objetivo es ayudar a los clientes con información sobre nuestros servicios.

INFORMACIÓN DE LA EMPRESA:

PLANES DISPONIBLES:
1. Plan Delivery: $350.000/mes - Ideal para trabajadores de delivery (Rappi, Uber Eats, Domicilios.com)
2. Plan Universitario: $280.000/mes - Especial para estudiantes
3. Plan Emprendedor: $400.000/mes - Para empresarios y emprendedores

MOTOS DISPONIBLES:
- Boxer 150: Ideal para delivery y trabajo urbano (Motor 150cc, bajo consumo)
- Discover 125: Perfecta para estudiantes (Motor 125cc, económica)
- Pulsar 180: Para emprendedores exigentes (Motor 180cc, mayor potencia)

REQUISITOS:
- Cédula de ciudadanía
- Licencia de conducción vigente
- Referencias personales
- Sin cuota inicial

BENEFICIOS INCLUIDOS:
- SOAT
- Seguro de Vida
- Seguro Todo Riesgo
- Fondo de Siniestralidad
- Asistencia Jurídica
- Mantenimiento preventivo y correctivo
- Soporte técnico 24/7

PROCESO:
1. Enviar datos y documentos
2. Aprobación en 24-48 horas
3. Escuela Renting365 (formación inicial)
4. Recibir moto y empezar a generar ingresos

COBERTURA:
- Actualmente: Cartagena
- Próximamente: Barranquilla y Santa Marta

CONTACTO:
- WhatsApp: +57 314 5144067
- Email: info@renting365.co
- Horario: Lunes a Sábado 8am - 6pm

DURACIÓN:
- Contratos flexibles de 6 a 24 meses
- Opción de compra al finalizar

Responde de manera amigable, concisa y profesional. Usa emojis cuando sea apropiado. Si no sabes algo, ofrece contactar a un asesor.";
    }

    protected function getFallbackResponse(string $message): array
    {
        $message = strtolower($message);
        
        if (strpos($message, 'plan') !== false || strpos($message, 'precio') !== false) {
            return [
                'success' => true,
                'message' => "Tenemos 3 planes:\n\n🏍️ Plan Delivery: $350.000/mes\n🎓 Plan Universitario: $280.000/mes\n💼 Plan Emprendedor: $400.000/mes\n\nTodos incluyen SOAT, seguros y mantenimiento. ¿Sobre cuál quieres más info?"
            ];
        }

        if (strpos($message, 'requisito') !== false || strpos($message, 'documento') !== false) {
            return [
                'success' => true,
                'message' => "Requisitos:\n\n✓ Cédula de ciudadanía\n✓ Licencia de conducción\n✓ Referencias personales\n✓ Sin cuota inicial\n\n¿Quieres iniciar el proceso?"
            ];
        }

        if (strpos($message, 'moto') !== false || strpos($message, 'modelo') !== false) {
            return [
                'success' => true,
                'message' => "Motos disponibles:\n\n🏍️ Boxer 150 - Delivery\n🏍️ Discover 125 - Estudiantes\n🏍️ Pulsar 180 - Emprendedores\n\n¿Cuál te interesa?"
            ];
        }

        return [
            'success' => true,
            'message' => "Puedo ayudarte con:\n\n• Planes y precios\n• Requisitos\n• Motos disponibles\n• Beneficios\n• Proceso de solicitud\n\n¿Qué te gustaría saber?"
        ];
    }
}
