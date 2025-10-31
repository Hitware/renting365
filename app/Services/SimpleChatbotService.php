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
            'keywords' => ['planes', 'plan', 'cuanto cuesta', 'precio', 'precios', 'cuotas', 'diario', 'dia'],
            'response' => "Tenemos 3 planes disponibles:\n\n📦 Plan Delivery - Para Trabajadores\n🎓 Plan Universitario - Para Estudiantes\n🛠️ Plan Emprendedor - Para Empresarios\n\n💵 Precio: $35.000 COP / Diarios\n\nTodos incluyen:\n• SOAT\n• Seguro de Vida\n• Seguro Todo Riesgo\n• Fondo de Siniestralidad\n• Asistencia Jurídica\n\n¿Quieres más información?"
        ],
        'requisitos' => [
            'keywords' => ['requisitos', 'requisito', 'documentos', 'necesito', 'que necesito', 'papeles'],
            'response' => "Los requisitos son muy sencillos:\n\n✓ Cédula de ciudadanía\n✓ Licencia de conducción vigente\n✓ Referencias personales\n✓ Cuota inicial (consulta monto con asesor)\n\n¿Te gustaría iniciar el proceso de solicitud?"
        ],
        'cuota_inicial' => [
            'keywords' => ['cuota inicial', 'inicial', 'cuota', 'anticipo', 'pago inicial', 'dinero inicial', 'inversion', 'fondo'],
            'response' => "Sí, se requiere un pago inicial que incluye:\n\n💰 Aporte al Fondo de Siniestralidad (10% del valor de la moto)\n🛡️ Seguros obligatorios iniciales\n\nEste fondo es clave para tu seguridad financiera en caso de accidente.\n\n¿Quieres que un asesor te informe el monto exacto? Te puedo conectar por WhatsApp."
        ],
        'motos' => [
            'keywords' => ['motos', 'moto', 'modelos', 'modelo', 'motocicletas', 'cual moto', 'auteco', 'tvs'],
            'response' => "Actualmente ofrecemos:\n\n🏍️ AUTECO TVS Sport 100\n\n• Motor 100cc\n• Ideal para delivery y trabajo urbano\n• Bajo consumo de combustible\n• Fácil mantenimiento\n• Diseño moderno y cómodo\n\n💵 $35.000 / Diarios\n\nIncluye mantenimiento y seguro completo. ¿Quieres más información?"
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
            'keywords' => ['como funciona', 'proceso', 'pasos', 'como solicitar', 'como empezar', 'funciona'],
            'response' => "El proceso es muy simple:\n\n1️⃣ Envíanos tus datos y documentos\n2️⃣ Aprobación en 24-48 horas\n3️⃣ Escuela Renting365 (formación obligatoria)\n   • Charla con Psicólogo\n   • Seguridad Vial\n   • Plan Emprendedor\n   • Manejo de Finanzas\n   • Servicio al Cliente\n4️⃣ Recibe tu moto\n5️⃣ ¡Empieza a generar ingresos!\n\n¿Quieres iniciar el proceso?"
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
            'keywords' => ['duracion', 'tiempo', 'contrato', 'cuanto tiempo', 'meses', 'finalizar', 'terminar'],
            'response' => "El modelo de Renting365:\n\n📄 La moto se registra a tu nombre desde el día 1\n🔒 Con prenda de garantía a favor de Renting365\n💵 Pagas cuota diaria o semanal\n✅ Al finalizar el contrato, la moto es 100% tuya\n\nSi tienes dificultades, puedes ceder tu cupo a otra persona (previa autorización).\n\n¿Te gustaría conocer más detalles?"
        ],
        'accidente' => [
            'keywords' => ['accidente', 'choque', 'daño', 'siniestro', 'que pasa si', 'incapacidad'],
            'response' => "Estás completamente protegido:\n\n🛡️ Seguro todo riesgo incluido\n💰 Fondo de Siniestralidad\n   • Cubre tus cuotas si quedas incapacitado temporalmente\n   • Te recuperas sin preocuparte por los pagos\n📞 Asistencia 24/7\n⚖️ Asistencia jurídica\n\nTu tranquilidad es nuestra prioridad."
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
        ],
        'escuela' => [
            'keywords' => ['escuela', 'capacitacion', 'formacion', 'curso', 'charlas', 'obligatorio'],
            'response' => "La Escuela Renting365 es OBLIGATORIA e INCLUIDA:\n\n🧠 1. Charla con Psicólogo\n🚗 2. Seguridad Vial\n💼 3. Plan Emprendedor\n💰 4. Manejo de Finanzas\n👥 5. Servicio al Cliente\n\nEs una inversión en tu desarrollo personal y profesional. ¡Te preparamos para el éxito!"
        ],
        'club' => [
            'keywords' => ['club', 'comunidad', 'descuentos', 'beneficios club'],
            'response' => "Club Renting365 - Exclusivo para clientes:\n\n👥 Comunidad exclusiva\n🔔 Alertas de movilidad en tiempo real\n🔧 Descuentos en repuestos y mantenimiento\n💼 Bolsa de empleo para domiciliarios\n📝 Envía tu CV para oportunidades laborales\n\n¡Incluido con tu plan Renting365!"
        ],
        'legal' => [
            'keywords' => ['legal', 'impuestos', 'formal', 'empresa', 'confiable'],
            'response' => "Renting365 es 100% legal y formal:\n\n✅ Operamos bajo todas las leyes colombianas\n📊 Cumplimos con obligaciones tributarias (IVA e Impuesto de Renta)\n🏢 Empresa comprometida con la economía local\n🔒 Transparencia en todos nuestros procesos\n\n¡Confía en nosotros!"
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
