<?php

namespace App\Services;

class SimpleChatbotService
{
    protected $responses = [
        'saludo' => [
            'keywords' => ['hola', 'buenos dias', 'buenas tardes', 'buenas noches', 'hey', 'saludos'],
            'response' => "¡Hola! 👋 Bienvenido a Renting365.\n\nSoy tu asistente virtual y estoy aquí para ayudarte con todo lo que necesites saber sobre nuestro servicio de renting de motos. ¿En qué puedo ayudarte hoy?"
        ],
        'planes' => [
            'keywords' => ['planes', 'plan', 'cuanto cuesta', 'precio', 'precios', 'cuotas', 'diario', 'dia', 'cuanto vale', 'costo', 'valor', 'cuanto pago', 'cuanto es'],
            'response' => "¡Perfecto! Te cuento sobre nuestro plan. 🚀\n\nTenemos un plan único y flexible:\n\n💵 $35.000 COP por día\n🏍️ Moto: AUTECO TVS Sport 100\n\nLo mejor es que TODO está incluido:\n✓ SOAT y Seguros\n✓ Mantenimiento completo\n✓ Fondo de Siniestralidad\n✓ Asistencia 24/7\n✓ Escuela Renting365\n\nY lo más importante: ¡La moto queda a TU NOMBRE desde el día 1! 🎉"
        ],
        'requisitos' => [
            'keywords' => ['requisitos', 'requisito', 'documentos', 'necesito', 'que necesito', 'papeles', 'que piden', 'que debo tener', 'que se necesita'],
            'response' => "¡Buena pregunta! Los requisitos son muy sencillos: 📝\n\n✓ Cédula de ciudadanía\n✓ Licencia de conducción vigente\n✓ Referencias personales\n✓ Aporte al Fondo de Siniestralidad (10% del valor de la moto)\n\nComo ves, no pedimos mucho. La idea es facilitarte el acceso a tu moto. 😊"
        ],
        'cuota_inicial' => [
            'keywords' => ['cuota inicial', 'inicial', 'anticipo', 'pago inicial', 'dinero inicial', 'inversion inicial', 'hay cuota inicial', 'debo pagar inicial', 'cuanto es la inicial'],
            'response' => "Sí, se requiere un pago inicial que incluye:\n\n💰 Aporte al Fondo de Siniestralidad (10% del valor de la moto)\n🛡️ Seguros obligatorios iniciales\n\nEste fondo es clave para tu seguridad financiera en caso de accidente.\n\n¿Quieres que un asesor te informe el monto exacto? Te puedo conectar por WhatsApp."
        ],
        'motos' => [
            'keywords' => ['motos', 'moto', 'modelos', 'modelo', 'motocicletas', 'cual moto', 'auteco', 'tvs', 'que moto', 'que motos tienen', 'motos disponibles', 'tipo de moto'],
            'response' => "Actualmente ofrecemos:\n\n🏍️ AUTECO TVS Sport 100\n\n• Motor 100cc\n• Ideal para delivery y trabajo urbano\n• Bajo consumo de combustible\n• Fácil mantenimiento\n• Diseño moderno y cómodo\n\n💵 $35.000 / Diarios\n\nIncluye mantenimiento y seguro completo. ¿Quieres más información?"
        ],
        'cobertura' => [
            'keywords' => ['donde', 'ubicacion', 'ciudad', 'ciudades', 'cobertura', 'operan', 'en que ciudad', 'donde estan', 'donde trabajan', 'que ciudades'],
            'response' => "📍 Actualmente operamos en Cartagena\n🔜 Próximamente en Barranquilla y Santa Marta\n\n¿Estás en Cartagena y te gustaría solicitar información?"
        ],
        'beneficios' => [
            'keywords' => ['beneficios', 'incluye', 'que incluye', 'que tiene incluido', 'viene incluido', 'que cubre', 'coberturas'],
            'response' => "Todos nuestros planes incluyen:\n\n✓ SOAT\n✓ Seguro de Vida\n✓ Seguro Todo Riesgo\n✓ Fondo de Siniestralidad\n✓ Asistencia Jurídica\n✓ Mantenimiento preventivo y correctivo\n✓ Soporte técnico 24/7\n\n¡Todo en una sola cuota mensual!"
        ],
        'proceso' => [
            'keywords' => ['como funciona', 'proceso', 'pasos', 'como solicitar', 'como empezar', 'funciona', 'como hago', 'como aplico', 'como obtengo'],
            'response' => "Te explico cómo funciona, es muy simple: 🚀\n\n1️⃣ Envías tus datos y documentos\n2️⃣ Te aprobamos en 24-48 horas\n3️⃣ Asistes a la Escuela Renting365 (obligatoria pero ¡incluida!)\n   • Charla con Psicólogo\n   • Seguridad Vial\n   • Plan Emprendedor\n   • Manejo de Finanzas\n   • Servicio al Cliente\n4️⃣ Recibes tu moto con todos los documentos\n5️⃣ ¡Empiezas a trabajar y generar ingresos!\n\nMuchos de nuestros clientes recuperan la cuota diaria en pocas horas de trabajo. 💪"
        ],
        'contacto' => [
            'keywords' => ['contacto', 'asesor', 'hablar', 'telefono', 'whatsapp', 'llamar', 'comunicar', 'si', 'quiero'],
            'response' => "¡Genial! 🎉 Me alegra que te interese.\n\nTe voy a conectar con un asesor por WhatsApp que resolverá todas tus dudas y te ayudará con el proceso.\n\n📱 +57 310 5367376\n\nEn un momento te redirijo...",
            'action' => [
                'type' => 'redirect',
                'url' => 'https://api.whatsapp.com/send?phone=573105367376&text=Hola!%20Vengo%20del%20chatbot%20y%20necesito%20informaci%C3%B3n%20sobre%20Renting365',
                'delay' => 2000
            ]
        ],
        'duracion' => [
            'keywords' => ['duracion', 'tiempo', 'contrato', 'cuanto tiempo', 'meses', 'finalizar', 'terminar', 'cuanto dura', 'plazo', 'cuando termina'],
            'response' => "El modelo de Renting365:\n\n📄 La moto se registra a tu nombre desde el día 1\n🔒 Con prenda de garantía a favor de Renting365\n💵 Pagas cuota diaria de $35.000 COP\n✅ Al finalizar el contrato, la moto es 100% tuya\n\nSi tienes dificultades, puedes ceder tu cupo a otra persona (previa autorización).\n\n¿Te gustaría conocer más detalles?"
        ],
        'obligaciones' => [
            'keywords' => ['obligaciones', 'responsabilidades', 'debo hacer', 'tengo que', 'cuidar', 'mantener', 'que debo hacer', 'mis obligaciones', 'responsabilidad'],
            'response' => "Como arrendatario, tus obligaciones son:\n\n✓ Pagar puntualmente la cuota diaria ($35.000)\n✓ Usar la moto para fines lícitos\n✓ Mantener la moto en buen estado\n✓ Asistir a mantenimientos programados\n✓ Reportar cualquier daño o accidente\n✓ No modificar la moto sin autorización\n✓ Mantener vigentes los seguros (incluidos en tu cuota)\n\nNosotros nos encargamos del mantenimiento y seguros. ¡Tú solo trabaja y genera ingresos!"
        ],
        'pagos' => [
            'keywords' => ['como pago', 'forma de pago', 'formas de pago', 'transferencia', 'efectivo', 'consignacion', 'donde pago', 'metodos de pago', 'puedo pagar'],
            'response' => "Formas de pago disponibles:\n\n💳 Transferencia bancaria\n💵 Efectivo en oficina\n📱 Pago móvil (Nequi, Daviplata)\n🏦 Consignación bancaria\n\n📅 Frecuencia: Diaria ($35.000) o Semanal\n⏰ Horario de pagos: Lunes a Sábado 8am-6pm\n\n¡Elige la forma que más te convenga!"
        ],
        'mora' => [
            'keywords' => ['mora', 'atraso', 'no pago', 'retraso', 'que pasa si no pago', 'si no pago', 'atrasar pago', 'pago tarde'],
            'response' => "Sobre los pagos atrasados:\n\n⚠️ Es importante mantener los pagos al día\n📞 Si tienes dificultades, comunícate inmediatamente\n🤝 Podemos buscar soluciones juntos\n💡 Opción de ceder el cupo a otra persona\n\nNuestra prioridad es ayudarte a mantener tu moto y tu fuente de ingresos. ¡Hablemos antes de que sea tarde!"
        ],
        'devolucion' => [
            'keywords' => ['devolver', 'devolucion', 'cancelar', 'terminar antes', 'ya no quiero', 'entregar', 'puedo devolver', 'quiero cancelar', 'salir del contrato'],
            'response' => "Si necesitas terminar el contrato antes:\n\n📋 Puedes ceder tu cupo a otra persona (previa aprobación)\n🔄 Evaluamos cada caso individualmente\n📞 Contacta a tu asesor para revisar opciones\n\nRecuerda: La moto está a tu nombre, trabajemos juntos para encontrar la mejor solución."
        ],
        'propiedad' => [
            'keywords' => ['propiedad', 'dueño', 'propietario', 'a mi nombre', 'tarjeta de propiedad', 'matricula', 'de quien es la moto', 'quien es el dueño', 'moto a mi nombre'],
            'response' => "Sobre la propiedad de la moto:\n\n✅ La moto se matricula a TU NOMBRE desde el inicio\n🔒 Con prenda de garantía a favor de Renting365\n📄 Recibes copia de la tarjeta de propiedad\n💯 Al finalizar pagos, la prenda se levanta\n🎉 La moto queda 100% a tu nombre sin deudas\n\n¡Desde el día 1 eres el propietario legal!"
        ],
        'multas' => [
            'keywords' => ['multas', 'comparendos', 'infracciones', 'fotomultas', 'transito', 'quien paga multas', 'si me multan', 'comparendo'],
            'response' => "Sobre multas y comparendos:\n\n⚠️ Las multas son responsabilidad del conductor\n📋 La moto está a tu nombre, las multas llegan a ti\n💡 Conduce siempre respetando las normas\n🎓 En la Escuela Renting365 te enseñamos seguridad vial\n\nRecuerda: Conducir seguro te ahorra dinero y problemas."
        ],
        'robo' => [
            'keywords' => ['robo', 'hurto', 'me roban', 'si me roban', 'perdida total', 'si roban la moto', 'que pasa si roban', 'roban moto'],
            'response' => "En caso de robo o pérdida total:\n\n🛡️ Cuentas con Seguro Todo Riesgo\n💰 Fondo de Siniestralidad activo\n📞 Reporta inmediatamente: +57 310 5367376\n📋 Proceso de reclamación al seguro\n⚖️ Asistencia jurídica incluida\n\nEstás protegido. Actuamos rápido para resolver la situación."
        ],
        'mantenimiento_detalle' => [
            'keywords' => ['que mantenimiento', 'mantenimiento incluido', 'revision', 'cambio aceite', 'reparacion', 'que cubre mantenimiento', 'incluye mantenimiento', 'mantenimiento gratis'],
            'response' => "El mantenimiento incluido cubre:\n\n🔧 Mantenimiento preventivo programado\n⚙️ Cambios de aceite y filtros\n🔩 Ajustes mecánicos necesarios\n🛠️ Reparaciones por desgaste normal\n📅 Revisiones periódicas\n\n❌ NO incluye:\n• Daños por mal uso\n• Accidentes por negligencia\n• Modificaciones no autorizadas\n\nTaller autorizado y repuestos originales."
        ],
        'documentos_entrega' => [
            'keywords' => ['que me entregan', 'documentos recibo', 'papeles', 'que documentos me dan', 'que recibo', 'me dan documentos', 'papeles entrega'],
            'response' => "Al recibir tu moto, te entregamos:\n\n📄 Copia de tarjeta de propiedad\n📋 Contrato de arrendamiento firmado\n🛡️ Pólizas de seguros (SOAT y Todo Riesgo)\n📱 Contactos de emergencia\n🔧 Manual de usuario de la moto\n📚 Certificado Escuela Renting365\n\n¡Todo en orden y legal!"
        ],
        'uso_comercial' => [
            'keywords' => ['uso comercial', 'trabajar', 'delivery', 'puedo trabajar', 'se puede trabajar', 'trabajo con la moto', 'usar para trabajar', 'generar ingresos'],
            'response' => "¡Claro que puedes trabajar con la moto!\n\n✅ Uso comercial permitido\n📦 Ideal para delivery (Rappi, Uber Eats, etc)\n🏢 Domicilios y mensajería\n💼 Transporte personal para tu negocio\n\nDe hecho, ¡ese es nuestro objetivo! Que generes ingresos y pagues tu moto trabajando con ella.\n\n💡 Muchos clientes recuperan la cuota diaria en pocas horas de trabajo."
        ],
        'accidente' => [
            'keywords' => ['accidente', 'choque', 'daño', 'siniestro', 'que pasa si', 'incapacidad', 'si tengo accidente', 'si choco', 'me accidento'],
            'response' => "Estás completamente protegido:\n\n🛡️ Seguro todo riesgo incluido\n💰 Fondo de Siniestralidad\n   • Cubre tus cuotas si quedas incapacitado temporalmente\n   • Te recuperas sin preocuparte por los pagos\n📞 Asistencia 24/7\n⚖️ Asistencia jurídica\n\nTu tranquilidad es nuestra prioridad."
        ],
        'gracias' => [
            'keywords' => ['gracias', 'muchas gracias', 'thank you', 'excelente', 'perfecto', 'ok', 'vale', 'entiendo'],
            'response' => "¡Con gusto! 😊 Para eso estoy aquí.\n\nSi tienes más preguntas, no dudes en hacerlas. Y si ya estás listo para dar el siguiente paso, puedo conectarte con un asesor que te ayudará con todo el proceso."
        ],
        'whatsapp' => [
            'keywords' => ['whatsapp', 'wa', 'escribir', 'mensaje', 'chat', 'redirige', 'ahora'],
            'response' => "¡Listo! Te estoy redirigiendo a WhatsApp...\n\n📱 +57 310 5367376",
            'action' => [
                'type' => 'redirect',
                'url' => 'https://api.whatsapp.com/send?phone=573105367376&text=Hola!%20Vengo%20del%20chatbot%20de%20Renting365',
                'delay' => 1500
            ]
        ],
        'horario' => [
            'keywords' => ['horario', 'hora', 'cuando', 'abierto', 'atienden', 'domingo'],
            'response' => "Nuestro horario de atención:\n\n🕒 Lunes a Sábado: 8:00 AM - 6:00 PM\n🚫 Domingos: Cerrado\n\n¡Pero este chatbot está disponible 24/7 para ti!\n\nPuedes escribirnos por WhatsApp en cualquier momento y te respondemos en horario laboral."
        ],
        'escuela' => [
            'keywords' => ['escuela', 'capacitacion', 'formacion', 'curso', 'charlas', 'obligatorio', 'que es escuela renting', 'para que es la escuela', 'escuela renting365', 'tengo que ir escuela'],
            'response' => "La Escuela Renting365 es OBLIGATORIA e INCLUIDA:\n\n🧠 1. Charla con Psicólogo\n🚗 2. Seguridad Vial\n💼 3. Plan Emprendedor\n💰 4. Manejo de Finanzas\n👥 5. Servicio al Cliente\n\nEs una inversión en tu desarrollo personal y profesional. ¡Te preparamos para el éxito!"
        ],
        'club' => [
            'keywords' => ['club', 'comunidad', 'descuentos', 'beneficios club', 'que es club renting', 'para que es el club', 'club renting365'],
            'response' => "Club Renting365 - Exclusivo para clientes:\n\n👥 Comunidad exclusiva\n🔔 Alertas de movilidad en tiempo real\n🔧 Descuentos en repuestos y mantenimiento\n💼 Bolsa de empleo para domiciliarios\n📝 Envía tu CV para oportunidades laborales\n\n¡Incluido con tu plan Renting365!"
        ],
        'legal' => [
            'keywords' => ['legal', 'impuestos', 'formal', 'empresa', 'confiable'],
            'response' => "Renting365 es 100% legal y formal:\n\n✅ Operamos bajo todas las leyes colombianas\n📊 Cumplimos con obligaciones tributarias (IVA e Impuesto de Renta)\n🏢 Empresa comprometida con la economía local\n🔒 Transparencia en todos nuestros procesos\n\n¡Confía en nosotros!"
        ],
        'cesion' => [
            'keywords' => ['ceder', 'cesion', 'traspasar', 'pasar a otro', 'otra persona', 'puedo ceder', 'transferir', 'pasar contrato'],
            'response' => "Sobre la cesión del contrato:\n\n✅ Puedes ceder tu cupo a otra persona\n📋 Requiere aprobación de Renting365\n🔍 La nueva persona debe cumplir requisitos\n📝 Se firma nuevo contrato\n💡 Útil si ya no puedes continuar\n\nContacta a tu asesor para iniciar el proceso de cesión."
        ],
        'garantias' => [
            'keywords' => ['garantia', 'garantias', 'respaldo', 'proteccion', 'que garantias', 'que me garantizan', 'seguridad'],
            'response' => "Tus garantías con Renting365:\n\n🛡️ Seguro Todo Riesgo\n📋 SOAT vigente\n💰 Fondo de Siniestralidad\n⚖️ Asistencia jurídica\n🔧 Mantenimiento incluido\n📞 Soporte 24/7\n📄 Contrato legal y transparente\n\n¡Tu inversión está protegida!"
        ],
        'soat' => [
            'keywords' => ['soat', 'que es soat', 'que es el soat', 'seguro obligatorio', 'para que es el soat', 'para que sirve el soat', 'para que soat', 'sirve el soat', 'significa soat'],
            'response' => "El SOAT (Seguro Obligatorio de Accidentes de Tránsito):\n\n📋 Es un seguro OBLIGATORIO en Colombia\n🏥 Cubre gastos médicos en caso de accidente\n👥 Protege a conductor, pasajeros y terceros\n💰 Cubre hasta ciertos montos establecidos por ley\n⚖️ Es requisito legal para circular\n\n✅ En Renting365 está INCLUIDO en tu cuota diaria\n🔄 Lo renovamos automáticamente\n\n¡Tú solo conduces tranquilo!"
        ],
        'todo_riesgo' => [
            'keywords' => ['todo riesgo', 'seguro todo riesgo', 'que cubre todo riesgo', 'seguro completo', 'para que es todo riesgo', 'para que sirve todo riesgo', 'que es todo riesgo', 'diferencia soat todo riesgo'],
            'response' => "El Seguro Todo Riesgo es mucho más completo que el SOAT:\n\n🛡️ Cubre daños a TU moto (no solo a terceros)\n🚗 Daños por colisión o volcamiento\n🔥 Incendio y explosión\n🌊 Daños por fenómenos naturales\n🚨 Robo total o parcial\n🔧 Asistencia en carretera\n⚖️ Responsabilidad civil\n\n✅ Incluido en tu cuota de $35.000/día\n💡 Es como tener un paraguas completo de protección\n\n¡Estás cubierto en casi cualquier situación!"
        ],
        'fondo_siniestralidad' => [
            'keywords' => ['fondo de siniestralidad', 'que es el fondo', 'fondo siniestralidad', 'para que sirve el fondo', 'para que es el fondo', 'que es fondo', 'fondo', 'siniestralidad'],
            'response' => "El Fondo de Siniestralidad es tu red de seguridad financiera:\n\n💰 Es un fondo común entre todos los clientes\n🏥 Si quedas incapacitado por accidente, el fondo PAGA TUS CUOTAS\n⏰ Te da tiempo para recuperarte sin perder la moto\n🤝 Todos aportamos, todos nos protegemos\n📊 Se requiere un aporte inicial del 10% del valor de la moto\n\n✨ Ejemplo práctico:\nTienes un accidente y quedas 2 meses sin poder trabajar. El fondo cubre tus cuotas durante ese tiempo. ¡No pierdes tu moto ni tu inversión!\n\nEs solidaridad que te protege. 💪"
        ],
        'asistencia_juridica' => [
            'keywords' => ['asistencia juridica', 'asistencia legal', 'abogado', 'juridica', 'legal', 'para que es asistencia juridica', 'que es asistencia juridica', 'sirve asistencia juridica'],
            'response' => "La Asistencia Jurídica incluida te protege legalmente:\n\n⚖️ Asesoría legal en caso de accidentes\n📋 Apoyo en trámites con autoridades\n👨‍⚖️ Representación legal si es necesario\n📞 Línea de consulta jurídica\n🚔 Orientación en comparendos\n\n✅ Incluido sin costo adicional\n💼 Abogados especializados en tránsito\n\n¡No enfrentas problemas legales solo!"
        ],
        'licencia' => [
            'keywords' => ['licencia', 'licencia de conduccion', 'pase', 'necesito licencia', 'que licencia necesito', 'cual licencia', 'tipo de licencia', 'categoria licencia'],
            'response' => "Sobre la Licencia de Conducción:\n\n📋 Es OBLIGATORIA para rentar la moto\n🏍️ Debe ser categoría A1 o A2 (para motos)\n✅ Debe estar VIGENTE (no vencida)\n📸 Necesitamos copia para el proceso\n⚠️ Sin licencia no podemos entregar la moto\n\n💡 Si no tienes licencia:\n• Debes tramitarla primero\n• En Colombia cuesta aprox. $200.000-$300.000\n• Incluye curso y examen\n\n¿Ya tienes tu licencia vigente?"
        ],
        'prenda' => [
            'keywords' => ['prenda', 'prenda de garantia', 'que es prenda', 'garantia prenda', 'para que es la prenda', 'que significa prenda', 'prenda garantia'],
            'response' => "La Prenda de Garantía explicada simple:\n\n📄 La moto se matricula a TU NOMBRE desde el día 1\n🔒 Pero con una 'prenda' a favor de Renting365\n💡 Es como una hipoteca: eres dueño pero no puedes venderla hasta pagar\n✅ Al terminar de pagar, levantamos la prenda\n🎉 La moto queda 100% tuya, sin restricciones\n\n🔍 Ventajas para ti:\n• Eres el propietario legal desde el inicio\n• Apareces en la tarjeta de propiedad\n• Las multas llegan a tu nombre (tú las pagas)\n• Al finalizar, es completamente tuya\n\n¡Es la forma legal de proteger ambas partes!"
        ],
        'tecnomecanica' => [
            'keywords' => ['tecnomecanica', 'revision tecnomecanica', 'rtm', 'tecno', 'que es tecnomecanica', 'para que es tecnomecanica', 'quien paga tecnomecanica'],
            'response' => "Sobre la Revisión Tecnomecánica:\n\n🔧 Es una inspección obligatoria del estado de la moto\n📅 Se hace cada año\n✅ Verifica frenos, luces, llantas, emisiones, etc.\n📋 Es requisito para circular legalmente\n\n💰 ¿Quién la paga en Renting365?\n• Está INCLUIDA en el mantenimiento\n• Nosotros nos encargamos de programarla\n• Tú solo llevas la moto cuando te avisamos\n\n¡Una preocupación menos para ti!"
        ],
        'cartagena' => [
            'keywords' => ['cartagena', 'estoy en cartagena', 'vivo en cartagena', 'opera en cartagena', 'en cartagena', 'cartagena colombia', 'estan en cartagena'],
            'response' => "¡Perfecto! Operamos en Cartagena. 🏖️\n\n📍 Ubicación: Cartagena, Colombia\n🏢 Oficina para atención presencial\n📦 Entrega de motos en la ciudad\n🔧 Taller autorizado local\n\n🔜 Próximamente también en:\n• Barranquilla\n• Santa Marta\n\n¿Te gustaría agendar una cita para conocer más?"
        ],
        'rappi' => [
            'keywords' => ['rappi', 'uber eats', 'domicilios.com', 'didi', 'apps de domicilios', 'aplicaciones', 'apps', 'plataformas', 'trabajar rappi'],
            'response' => "¡Excelente! Muchos de nuestros clientes trabajan en apps de domicilios. 📦\n\n✅ Puedes trabajar en:\n• Rappi\n• Uber Eats\n• Didi Food\n• Domicilios.com\n• Cualquier app de delivery\n\n💡 Datos reales de nuestros clientes:\n• Ganan entre $80.000 - $150.000 diarios\n• Recuperan la cuota ($35.000) en 3-4 horas\n• El resto es ganancia pura\n\n🏍️ La AUTECO TVS Sport 100 es ideal para esto:\n• Bajo consumo (rinde mucho la gasolina)\n• Ágil en el tráfico\n• Cómoda para todo el día\n\n¿Quieres saber cómo empezar?"
        ],
        'consumo' => [
            'keywords' => ['consumo', 'gasta gasolina', 'cuanto gasta', 'rendimiento', 'kilometros por galon', 'cuanto consume', 'gasto gasolina', 'rinde gasolina', 'kilometros litro'],
            'response' => "Sobre el consumo de la AUTECO TVS Sport 100:\n\n⛽ Rendimiento aproximado:\n• 40-45 km por litro en ciudad\n• 50-55 km por litro en carretera\n• Motor 100cc muy eficiente\n\n💰 Costo diario estimado de gasolina:\n• Si trabajas 8 horas en delivery: $15.000-$20.000\n• Depende de cuánto recorras\n\n📊 Ejemplo real:\n• Cuota diaria: $35.000\n• Gasolina: $18.000\n• Ganas trabajando: $120.000\n• Ganancia neta: $67.000/día\n\n¡La moto es muy económica! 🎉"
        ],
        'edad' => [
            'keywords' => ['edad', 'cuantos años', 'edad minima', 'mayor de edad', 'tengo 17', 'que edad', 'edad necesaria', 'puedo si tengo', 'menor de edad'],
            'response' => "Sobre la edad para rentar:\n\n✅ Debes ser mayor de edad (18 años cumplidos)\n📋 Con cédula de ciudadanía\n🏍️ Y licencia de conducción vigente\n\n⚠️ Si eres menor de 18:\n• Debes esperar a cumplir la mayoría de edad\n• Mientras tanto, puedes tramitar tu licencia\n• Así cuando cumplas 18, ¡ya estás listo!\n\n¿Cumples con estos requisitos?"
        ],
        'estudiante' => [
            'keywords' => ['estudiante', 'estudio', 'universidad', 'colegio', 'soy estudiante', 'para estudiantes', 'si estudio', 'universitario'],
            'response' => "¡Perfecto para estudiantes! 🎓\n\n💡 Ventajas para ti:\n• Cuota diaria de solo $35.000\n• Puedes trabajar en delivery en tu tiempo libre\n• Muchos estudiantes pagan la cuota en 3-4 horas\n• El resto del día es ganancia\n\n📚 Ejemplo de estudiante típico:\n• Estudia en la mañana\n• Trabaja en Rappi 4-5 horas en la tarde\n• Gana $80.000-$100.000 diarios\n• Paga la moto y le sobra para gastos\n\n🏍️ La moto también te sirve para:\n• Ir a la universidad\n• Ahorrar en transporte\n• Independencia total\n\n¿Te interesa?"
        ],
        'referencias' => [
            'keywords' => ['referencias', 'referencias personales', 'que referencias', 'cuantas referencias', 'para que referencias', 'quien puede ser referencia', 'necesito referencias'],
            'response' => "Sobre las referencias personales:\n\n👥 Necesitamos 2-3 referencias\n📋 Pueden ser:\n• Familiares (no que vivan contigo)\n• Amigos cercanos\n• Compañeros de trabajo\n• Vecinos\n\n📞 Qué necesitamos de cada referencia:\n• Nombre completo\n• Teléfono de contacto\n• Relación contigo (amigo, familiar, etc.)\n\n💡 Las contactamos para:\n• Verificar que te conocen\n• Confirmar que eres responsable\n• Es un proceso rápido y sencillo\n\n¿Ya tienes tus referencias listas?"
        ]
    ];

    protected $suggestions = [
        'saludo' => ['planes', 'requisitos', 'motos'],
        'planes' => ['requisitos', 'motos', 'beneficios'],
        'requisitos' => ['proceso', 'cuota_inicial', 'licencia'],
        'cuota_inicial' => ['pagos', 'fondo_siniestralidad', 'contacto'],
        'motos' => ['consumo', 'uso_comercial', 'planes'],
        'cobertura' => ['cartagena', 'contacto', 'proceso'],
        'beneficios' => ['soat', 'todo_riesgo', 'fondo_siniestralidad'],
        'proceso' => ['requisitos', 'escuela', 'contacto'],
        'duracion' => ['propiedad', 'prenda', 'cesion'],
        'accidente' => ['todo_riesgo', 'fondo_siniestralidad', 'asistencia_juridica'],
        'escuela' => ['proceso', 'beneficios', 'contacto'],
        'club' => ['beneficios', 'uso_comercial', 'contacto'],
        'obligaciones' => ['pagos', 'mantenimiento_detalle', 'multas'],
        'pagos' => ['mora', 'contacto', 'planes'],
        'mora' => ['devolucion', 'cesion', 'contacto'],
        'devolucion' => ['cesion', 'contacto', 'obligaciones'],
        'propiedad' => ['prenda', 'duracion', 'cesion'],
        'multas' => ['obligaciones', 'escuela', 'contacto'],
        'robo' => ['todo_riesgo', 'fondo_siniestralidad', 'contacto'],
        'mantenimiento_detalle' => ['tecnomecanica', 'obligaciones', 'contacto'],
        'documentos_entrega' => ['proceso', 'propiedad', 'contacto'],
        'uso_comercial' => ['rappi', 'consumo', 'estudiante'],
        'cesion' => ['devolucion', 'propiedad', 'contacto'],
        'garantias' => ['soat', 'todo_riesgo', 'fondo_siniestralidad'],
        'soat' => ['todo_riesgo', 'beneficios', 'tecnomecanica'],
        'todo_riesgo' => ['soat', 'robo', 'accidente'],
        'fondo_siniestralidad' => ['cuota_inicial', 'accidente', 'beneficios'],
        'asistencia_juridica' => ['multas', 'accidente', 'beneficios'],
        'licencia' => ['requisitos', 'edad', 'proceso'],
        'prenda' => ['propiedad', 'duracion', 'cesion'],
        'tecnomecanica' => ['mantenimiento_detalle', 'obligaciones', 'beneficios'],
        'cartagena' => ['cobertura', 'contacto', 'proceso'],
        'rappi' => ['uso_comercial', 'consumo', 'estudiante'],
        'consumo' => ['motos', 'rappi', 'planes'],
        'edad' => ['requisitos', 'licencia', 'estudiante'],
        'estudiante' => ['planes', 'rappi', 'uso_comercial'],
        'referencias' => ['requisitos', 'proceso', 'contacto']
    ];

    protected function getSuggestions(string $category): string
    {
        if (!isset($this->suggestions[$category])) {
            return "\n\n¿Quieres saber algo más?";
        }

        $suggested = $this->suggestions[$category];
        $texts = [
            'planes' => '💰 Ver planes y precios',
            'requisitos' => '📝 Requisitos necesarios',
            'motos' => '🏍️ Motos disponibles',
            'beneficios' => '✨ Beneficios incluidos',
            'proceso' => '🚀 Cómo funciona el proceso',
            'contacto' => '📞 Hablar con un asesor',
            'cuota_inicial' => '💵 Sobre la cuota inicial',
            'pagos' => '💳 Formas de pago',
            'escuela' => '🎓 Escuela Renting365',
            'club' => '👥 Club Renting365',
            'cobertura' => '📍 Ciudades disponibles',
            'accidente' => '🛡️ Qué pasa en accidentes',
            'robo' => '🚨 Cobertura por robo',
            'duracion' => '⏱️ Duración del contrato',
            'propiedad' => '📄 Propiedad de la moto',
            'obligaciones' => '✅ Mis obligaciones',
            'mora' => '⚠️ Pagos atrasados',
            'devolucion' => '🔄 Devolver la moto',
            'multas' => '🚦 Multas de tránsito',
            'mantenimiento_detalle' => '🔧 Mantenimiento incluido',
            'documentos_entrega' => '📋 Documentos que recibo',
            'uso_comercial' => '💼 Uso comercial',
            'cesion' => '🔄 Ceder el contrato',
            'garantias' => '🛡️ Garantías',
            'soat' => '📋 ¿Qué es el SOAT?',
            'todo_riesgo' => '🛡️ ¿Qué es el Seguro Todo Riesgo?',
            'fondo_siniestralidad' => '💰 ¿Qué es el Fondo de Siniestralidad?',
            'asistencia_juridica' => '⚖️ Asistencia jurídica',
            'licencia' => '📋 Sobre la licencia de conducción',
            'prenda' => '🔒 ¿Qué es la prenda de garantía?',
            'tecnomecanica' => '🔧 Revisión tecnomecánica',
            'cartagena' => '🏖️ Servicio en Cartagena',
            'rappi' => '📦 Trabajar en apps de domicilios',
            'consumo' => '⛽ Consumo de gasolina',
            'edad' => '🎂 Edad mínima requerida',
            'estudiante' => '🎓 Plan para estudiantes',
            'referencias' => '👥 Referencias personales'
        ];

        $suggestions = [];
        foreach ($suggested as $key) {
            if (isset($texts[$key])) {
                $suggestions[] = $texts[$key];
            }
        }

        if (empty($suggestions)) {
            return "\n\n¿Quieres saber algo más?";
        }

        return "\n\nTambién te puede interesar:\n" . implode("\n", $suggestions);
    }

    public function getResponse(string $message): array
    {
        $message = strtolower($message);
        
        foreach ($this->responses as $category => $data) {
            foreach ($data['keywords'] as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    $response = [
                        'success' => true,
                        'message' => $data['response'] . $this->getSuggestions($category),
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
            'message' => "Mmm, no estoy seguro de entender tu pregunta. 🤔\n\nPuedo ayudarte con temas como:\n\n💰 Planes y precios\n📝 Requisitos y documentos\n🏍️ Motos disponibles\n🛡️ Seguros (SOAT, Todo Riesgo)\n💰 Fondo de Siniestralidad\n📦 Trabajar en delivery\n⛽ Consumo de gasolina\n🔒 Propiedad y prenda\n📞 Contacto con asesor\n\nEscribe sobre qué quieres saber o pregunta algo específico.",
            'category' => 'default'
        ];
    }
}
