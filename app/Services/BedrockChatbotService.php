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

PLANES Y PRECIOS:
- Cuota diaria: $35.000 COP
- Disponible para: Delivery, Estudiantes y Emprendedores
- Sin cuota inicial (se requiere aporte al Fondo de Siniestralidad: 10% del valor de la moto)

MOTOS DISPONIBLES:
- AUTECO TVS Sport 100: Motor 100cc, ideal para delivery y trabajo urbano, bajo consumo

REQUISITOS:
- Cédula de ciudadanía
- Licencia de conducción vigente
- Referencias personales
- Aporte inicial al Fondo de Siniestralidad (10% del valor de la moto)

BENEFICIOS INCLUIDOS:
- SOAT
- Seguro de Vida
- Seguro Todo Riesgo
- Fondo de Siniestralidad (cubre cuotas si quedas incapacitado)
- Asistencia Jurídica
- Mantenimiento preventivo y correctivo (aceite, filtros, ajustes)
- Soporte técnico 24/7

PROCESO:
1. Enviar datos y documentos
2. Aprobación en 24-48 horas
3. Escuela Renting365 OBLIGATORIA (incluida):
   - Charla con Psicólogo
   - Seguridad Vial
   - Plan Emprendedor
   - Manejo de Finanzas
   - Servicio al Cliente
4. Recibir moto y documentos
5. Empezar a generar ingresos

DOCUMENTOS QUE RECIBES:
- Copia de tarjeta de propiedad (a tu nombre)
- Contrato de arrendamiento
- Pólizas de seguros
- Contactos de emergencia
- Manual de usuario
- Certificado Escuela Renting365

PROPIEDAD Y CONTRATO:
- La moto se matricula a TU NOMBRE desde el día 1
- Con prenda de garantía a favor de Renting365
- Al finalizar pagos, la prenda se levanta y la moto es 100% tuya
- Puedes ceder el cupo a otra persona (previa aprobación)

OBLIGACIONES DEL CLIENTE:
- Pagar puntualmente la cuota diaria
- Usar la moto para fines lícitos
- Mantener la moto en buen estado
- Asistir a mantenimientos programados
- Reportar daños o accidentes inmediatamente
- No modificar la moto sin autorización

FORMAS DE PAGO:
- Transferencia bancaria
- Efectivo en oficina
- Pago móvil (Nequi, Daviplata)
- Consignación bancaria
- Frecuencia: Diaria o Semanal

USO COMERCIAL:
- Permitido y recomendado
- Ideal para delivery (Rappi, Uber Eats, Domicilios.com)
- Mensajería y transporte
- Muchos clientes recuperan la cuota en pocas horas de trabajo

EN CASO DE ACCIDENTE/ROBO:
- Seguro Todo Riesgo activo
- Fondo de Siniestralidad cubre cuotas si quedas incapacitado
- Asistencia jurídica incluida
- Reportar inmediatamente al +57 310 5367376

MULTAS Y COMPARENDOS:
- Son responsabilidad del conductor
- La moto está a tu nombre
- Conduce respetando las normas

CLUB RENTING365 (Exclusivo para clientes):
- Comunidad exclusiva
- Alertas de movilidad en tiempo real
- Descuentos en repuestos y mantenimiento
- Bolsa de empleo para domiciliarios

COBERTURA:
- Actualmente: Cartagena
- Próximamente: Barranquilla y Santa Marta

CONTACTO:
- WhatsApp: +57 310 5367376
- Horario: Lunes a Sábado 8am - 6pm

Responde de manera amigable, concisa y profesional. Usa emojis cuando sea apropiado. Si no sabes algo específico, ofrece contactar a un asesor por WhatsApp. Nunca inventes información que no esté aquí.";
    }

    protected function getFallbackResponse(string $message): array
    {
        $message = strtolower($message);
        
        if (strpos($message, 'plan') !== false || strpos($message, 'precio') !== false) {
            return [
                'success' => true,
                'message' => "Nuestro plan de renting:\n\n💵 Cuota diaria: $35.000 COP\n🏍️ Moto: AUTECO TVS Sport 100\n\nIncluye:\n✓ SOAT y Seguros\n✓ Mantenimiento\n✓ Fondo de Siniestralidad\n✓ Asistencia 24/7\n\n¿Quieres más información?"
            ];
        }

        if (strpos($message, 'requisito') !== false || strpos($message, 'documento') !== false) {
            return [
                'success' => true,
                'message' => "Requisitos:\n\n✓ Cédula de ciudadanía\n✓ Licencia de conducción\n✓ Referencias personales\n✓ Aporte al Fondo de Siniestralidad (10% del valor de la moto)\n\n¿Quieres iniciar el proceso?"
            ];
        }

        if (strpos($message, 'moto') !== false || strpos($message, 'modelo') !== false) {
            return [
                'success' => true,
                'message' => "Moto disponible:\n\n🏍️ AUTECO TVS Sport 100\n• Motor 100cc\n• Bajo consumo\n• Ideal para delivery y trabajo urbano\n• Fácil mantenimiento\n\n💵 $35.000/día\n\n¿Quieres más información?"
            ];
        }

        return [
            'success' => true,
            'message' => "Puedo ayudarte con:\n\n• Planes y precios\n• Requisitos\n• Motos disponibles\n• Beneficios\n• Proceso de solicitud\n\n¿Qué te gustaría saber?"
        ];
    }
}
