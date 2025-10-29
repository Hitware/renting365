<?php

namespace App\Services;

class SimpleChatbotService
{
    protected $responses = [
        'saludo' => [
            'keywords' => ['hola', 'buenos dias', 'buenas tardes', 'buenas noches', 'hey', 'saludos'],
            'response' => "¡Hola! 👋 Bienvenido a Renting365. Soy tu asistente virtual y estoy aquí para ayudarte.\n\n¿En qué puedo ayudarte hoy?\n\n• Ver planes disponibles\n• Conocer requisitos\n• Información de motos\n• Hablar con un asesor"
        ],
        'planes' => [
            'keywords' => ['planes', 'plan', 'cuanto cuesta', 'precio', 'precios', 'cuotas'],
            'response' => "Tenemos 3 planes disponibles:\n\n🏍️ Plan Delivery: $350.000/mes - Ideal para trabajadores de delivery\n🎓 Plan Universitario: $280.000/mes - Especial para estudiantes\n💼 Plan Emprendedor: $400.000/mes - Para empresarios\n\nTodos incluyen SOAT, seguro de vida, todo riesgo y mantenimiento.\n\n*Se requiere cuota inicial (consulta monto con asesor)\n\n¿Sobre cuál te gustaría más información?"
        ],
        'requisitos' => [
            'keywords' => ['requisitos', 'requisito', 'documentos', 'necesito', 'que necesito', 'papeles'],
            'response' => "Los requisitos son muy sencillos:\n\n✓ Cédula de ciudadanía\n✓ Licencia de conducción vigente\n✓ Referencias personales\n✓ Cuota inicial (consulta monto con asesor)\n\n¿Te gustaría iniciar el proceso de solicitud?"
        ],
        'cuota_inicial' => [
            'keywords' => ['cuota inicial', 'inicial', 'cuota', 'anticipo', 'pago inicial', 'dinero inicial'],
            'response' => "Sí, se requiere una cuota inicial para adquirir tu moto.\n\nEl monto de la cuota inicial varía según el plan y la moto que elijas.\n\n¿Quieres que un asesor te informe el monto exacto? Te puedo conectar por WhatsApp."
        ],
        'motos' => [
            'keywords' => ['motos', 'moto', 'modelos', 'modelo', 'motocicletas', 'cual moto'],
            'response' => "Nuestras motos disponibles:\n\n🏍️ Boxer 150 - Ideal para delivery y trabajo urbano\n🏍️ Discover 125 - Perfecta para estudiantes\n🏍️ Pulsar 180 - Para emprendedores exigentes\n\nTodas con mantenimiento incluido y seguro completo. ¿Quieres ver la ficha técnica de alguna?"
        ],
        'cobertura' => [
            'keywords' => ['donde', 'ubicacion', 'ciudad', 'ciudades', 'cobertura', 'operan'],
            'response' => "📍 Actualmente operamos en Cartagena\n🔜 Próximamente en Barranquilla y Santa Marta\n\n¿Estás en Cartagena y te gustaría solicitar información?"
        ],
        'beneficios' => [
            'keywords' => ['beneficios', 'incluye', 'que incluye', 'seguro', 'soat', 'mantenimiento'],
            'response' => "Todos nuestros planes incluyen:\n\n✓ SOAT\n✓ Seguro de Vida\n✓ Seguro Todo Riesgo\n✓ Fondo de Siniestralidad\n✓ Asistencia Jurídica\n✓ Mantenimiento preventivo y correctivo\n✓ Soporte técnico 24/7\n\n¡Todo en una sola cuota mensual!"
        ],
        'proceso' => [
            'keywords' => ['como funciona', 'proceso', 'pasos', 'como solicitar', 'como empezar'],
            'response' => "El proceso es muy simple:\n\n1️⃣ Envíanos tus datos y documentos\n2️⃣ Aprobación en 24-48 horas\n3️⃣ Escuela Renting365 (formación inicial)\n4️⃣ ¡Recibe tu moto y empieza a generar ingresos!\n\n¿Quieres que te contacte un asesor?"
        ],
        'contacto' => [
            'keywords' => ['contacto', 'asesor', 'hablar', 'telefono', 'whatsapp', 'llamar', 'comunicar', 'si', 'quiero'],
            'response' => "¡Perfecto! Te voy a conectar con un asesor por WhatsApp.\n\n📱 +57 314 5144067\n\nEn un momento te redigiré...",
            'action' => [
                'type' => 'redirect',
                'url' => 'https://api.whatsapp.com/send?phone=573145144067&text=Hola!%20Vengo%20del%20chatbot%20y%20necesito%20informaci%C3%B3n%20sobre%20Renting365',
                'delay' => 2000
            ]
        ],
        'duracion' => [
            'keywords' => ['duracion', 'tiempo', 'contrato', 'cuanto tiempo', 'meses'],
            'response' => "Ofrecemos contratos flexibles:\n\n⏱️ Desde 6 meses hasta 24 meses\n\nTú eliges la duración según tus necesidades. Al finalizar, tienes opción de compra de la moto a precio preferencial."
        ],
        'accidente' => [
            'keywords' => ['accidente', 'choque', 'daño', 'siniestro', 'que pasa si'],
            'response' => "Estás completamente protegido:\n\n🛡️ Seguro todo riesgo incluido\n💰 Fondo de siniestralidad\n📞 Asistencia 24/7\n⚖️ Asistencia jurídica\n\nNosotros nos encargamos de todo. Tu tranquilidad es nuestra prioridad."
        ],
        'gracias' => [
            'keywords' => ['gracias', 'muchas gracias', 'thank you', 'excelente', 'perfecto'],
            'response' => "¡De nada! 😊 Estoy aquí para ayudarte.\n\n¿Hay algo más en lo que pueda asistirte?\n\nSi estás listo para comenzar, puedo conectarte con un asesor."
        ],
        'whatsapp' => [
            'keywords' => ['whatsapp', 'wa', 'escribir', 'mensaje', 'chat', 'redirige', 'ahora'],
            'response' => "¡Listo! Te estoy redirigiendo a WhatsApp...\n\n📱 +57 314 5144067",
            'action' => [
                'type' => 'redirect',
                'url' => 'https://api.whatsapp.com/send?phone=573145144067&text=Hola!%20Vengo%20del%20chatbot%20de%20Renting365',
                'delay' => 1500
            ]
        ],
        'horario' => [
            'keywords' => ['horario', 'hora', 'cuando', 'abierto', 'atienden'],
            'response' => "Nuestro horario de atención:\n\n🕒 Lunes a Sábado: 8:00 AM - 6:00 PM\n🚫 Domingos: Cerrado\n\n¡Pero este chatbot está disponible 24/7 para ti!"
        ]
    ];

    public function getResponse(string $message): array
    {
        $message = strtolower($message);
        
        foreach ($this->responses as $category => $data) {
            foreach ($data['keywords'] as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    $response = [
                        'success' => true,
                        'message' => $data['response'],
                        'category' => $category
                    ];
                    
                    if (isset($data['action'])) {
                        $response['action'] = $data['action'];
                    }
                    
                    return $response;
                }
            }
        }

        return [
            'success' => true,
            'message' => "Entiendo tu pregunta. 🤔\n\nPuedo ayudarte con:\n\n💰 Planes y precios\n📝 Requisitos y documentos\n🏍️ Motos disponibles\n📍 Cobertura y ubicación\n✨ Beneficios incluidos\n🚀 Proceso de solicitud\n📞 Contacto con asesor\n\n¿Qué información necesitas?",
            'category' => 'default'
        ];
    }
}
