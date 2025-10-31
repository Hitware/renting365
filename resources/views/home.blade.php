<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renting365 - Facilita tu vida</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
        .brand-gradient { background: linear-gradient(90deg, #FF6B35 0%, #F7931E 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .typing-dots .dot {
            animation: typing 1.4s infinite;
            opacity: 0;
        }
        .typing-dots .dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        .typing-dots .dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        @keyframes typing {
            0%, 60%, 100% { opacity: 0; }
            30% { opacity: 1; }
        }
    </style>
</head>
<body class="antialiased">
    <!-- Top Bar -->
    <div class="bg-orange-600 text-white py-2">
        <div class="container mx-auto px-4 flex flex-col sm:flex-row justify-between items-center text-xs sm:text-sm gap-2">
            <div class="flex flex-wrap gap-3 sm:gap-6 justify-center">
                <span>📞 +57 314 5144067</span>
                <span>📍 Cartagena, Colombia</span>
            </div>
            <div class="hidden sm:block">¡Renta tu moto hoy mismo!</div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <img src="{{ asset('images/home/logo.png') }}" alt="Renting365" class="h-4 sm:h-5" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="#inicio" class="text-gray-700 hover:text-orange-600 text-sm">Inicio</a>
                    <a href="#planes" class="text-gray-700 hover:text-orange-600 text-sm">Planes</a>
                    <a href="#motos" class="text-gray-700 hover:text-orange-600 text-sm">Motos</a>
                    <a href="#faq" class="text-gray-700 hover:text-orange-600 text-sm">FAQ</a>
                </nav>
                <a href="{{ route('login') }}" class="px-4 sm:px-6 py-2 bg-orange-600 text-white rounded-full hover:bg-orange-700 text-xs sm:text-sm font-medium">INICIAR SESIÓN</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="relative min-h-[500px] sm:min-h-[600px] md:min-h-[700px] lg:min-h-screen flex items-center justify-center overflow-hidden bg-gray-900">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/home/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover object-[center_30%] sm:object-center">
            <div class="absolute inset-0 bg-black/40"></div>
        </div>
        
        <!-- Content -->
        <div class="container mx-auto px-4 text-center relative z-20 py-8">
            <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-4 sm:mb-6 text-white leading-tight" style="text-shadow: 0 4px 20px rgba(0,0,0,0.8);">
                <span class="block">Renting365</span>
                <span class="block text-orange-500">Facilita tu vida.</span>
            </h1>
            <p class="text-base sm:text-xl md:text-2xl text-white mb-6 sm:mb-8 max-w-3xl mx-auto font-light px-4" style="text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                Tu oportunidad de generar ingresos y moverte con seguridad y confianza.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center px-4">
                <a href="#planes" class="w-full sm:w-auto px-8 py-3 sm:px-10 sm:py-4 bg-orange-600 text-white rounded-full hover:bg-orange-700 transition-all text-base sm:text-lg font-semibold shadow-2xl">Ver Planes Disponibles</a>
                <a href="https://api.whatsapp.com/send?phone=573145144067&text=Hola!%20👋%20Estoy%20interesado%20en%20adquirir%20una%20moto%20con%20Renting365" class="w-full sm:w-auto px-8 py-3 sm:px-10 sm:py-4 bg-green-600 text-white rounded-full hover:bg-green-700 transition-all text-base sm:text-lg font-semibold shadow-2xl">Hablar con un Asesor</a>
            </div>
        </div>
    </section>

    <!-- Planes Section -->
    <section id="planes" class="py-10 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h3 class="text-3xl sm:text-4xl font-bold mb-3">Planes Disponibles</h3>
                <p class="text-sm sm:text-base text-gray-600 max-w-3xl mx-auto">Encuentra la moto perfecta para trabajar. Todas nuestras motos incluyen mantenimiento, seguro y soporte técnico las 24 horas.</p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Plan Delivery -->
                <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition">
                    <img src="{{ asset('images/home/img-delivery.png') }}" alt="Plan Delivery" class="w-full mb-4">
                    <div class="w-16 h-16 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-2xl">📦</div>
                    <h3 class="text-2xl font-bold text-center mb-2">Plan Delivery</h3>
                    <p class="text-center text-gray-600 mb-3">Para Trabajadores</p>
                    <p class="text-center text-gray-700 mb-4">Perfectas para trabajar en apps como Rappi, Uber Eats y Domicilios.com. En <strong>Renting365</strong> ofrecen excelente rendimiento en ciudad.</p>
                    <a href="#financiamiento" class="block w-full px-6 py-3 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700">Ver Planes</a>
                </div>

                <!-- Plan Universitario -->
                <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition">
                    <img src="{{ asset('images/home/img-student.png') }}" alt="Plan Universitario" class="w-full mb-4">
                    <div class="w-16 h-16 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-2xl">🎓</div>
                    <h3 class="text-2xl font-bold text-center mb-2">Plan Universitario</h3>
                    <p class="text-center text-gray-600 mb-3">Para Estudiantes</p>
                    <p class="text-center text-gray-700 mb-4">Ideales para la vida universitaria y moverte ligero por la ciudad. En <strong>Renting365</strong> es simple, claro y cercano.</p>
                    <a href="#financiamiento" class="block w-full px-6 py-3 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700">Ver Planes</a>
                </div>

                <!-- Plan Emprendedor -->
                <div class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition">
                    <img src="{{ asset('images/home/img-trabajador.png') }}" alt="Plan Emprendedor" class="w-full mb-4">
                    <div class="w-16 h-16 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-2xl">🛠️</div>
                    <h3 class="text-2xl font-bold text-center mb-2">Plan Emprendedor</h3>
                    <p class="text-center text-gray-600 mb-3">Para Empresarios</p>
                    <p class="text-center text-gray-700 mb-4">Hechas para potenciar tu oficio y crecer con confianza. En <strong>Renting365</strong> empiezas fácil, con apoyo real cuando importa.</p>
                    <a href="#financiamiento" class="block w-full px-6 py-3 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700">Ver Planes</a>
                </div>
            </div>

            <div class="bg-orange-50 rounded-2xl p-6 text-center">
                <p class="text-gray-800"><strong>Lo que incluye:</strong> SOAT, Seguro de Vida, Seguro Todo Riesgo, Fondo de Siniestralidad y Asistencia Jurídica. ¿Tienes preguntas? Te acompañamos en cada paso. 👇</p>
            </div>
        </div>
    </section>

    <!-- Beneficios Section -->
    <section class="py-10 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h3 class="text-4xl font-bold mb-4">Beneficios Incluidos<br>Con <span class="brand-gradient">Renting365</span></h3>
                <p class="text-gray-600">Todo esto viene con tu moto desde el primer día.<br>Sin costos ocultos, sin letra pequeña.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-xl p-6 shadow-lg flex items-start gap-4">
                    <img src="{{ asset('images/home/icon-soat.webp') }}" alt="SOAT" class="w-16 h-16">
                    <div>
                        <h4 class="text-xl font-bold mb-2">SOAT Incluido ✓</h4>
                        <p class="text-gray-600">Seguro obligatorio de accidentes de tránsito incluido.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg flex items-start gap-4">
                    <img src="{{ asset('images/home/icon-seguro-vida.webp') }}" alt="Seguro de Vida" class="w-16 h-16">
                    <div>
                        <h4 class="text-xl font-bold mb-2">Seguro de Vida ✓</h4>
                        <p class="text-gray-600">Cobertura de vida para tu tranquilidad.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg flex items-start gap-4">
                    <img src="{{ asset('images/home/icon-todo-riesgo.webp') }}" alt="Todo Riesgo" class="w-16 h-16">
                    <div>
                        <h4 class="text-xl font-bold mb-2">Seguro Todo Riesgo ✓</h4>
                        <p class="text-gray-600">Protege tu inversión en caso de perdida total o robo.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg flex items-start gap-4">
                    <img src="{{ asset('images/home/icon-siniestralidad.webp') }}" alt="Fondo Siniestralidad" class="w-16 h-16">
                    <div>
                        <h4 class="text-xl font-bold mb-2">Fondo de Siniestralidad ✓</h4>
                        <p class="text-gray-600">Protección financiera en caso de accidentes.</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg flex items-start gap-4 md:col-span-2 max-w-md mx-auto">
                    <img src="{{ asset('images/home/icon-todo-riesgo.webp') }}" alt="Asistencia Jurídica" class="w-16 h-16">
                    <div>
                        <h4 class="text-xl font-bold mb-2">Asistencia Jurídica ✓</h4>
                        <p class="text-gray-600">Asesoría legal cuando lo necesites.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo Funciona Section -->
    <section class="py-10 bg-gradient-to-br from-orange-500 to-orange-600 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold mb-3">¿Cómo Funciona?</h3>
                <p class="text-base">Un proceso sencillo y rápido para que comiences a generar ingresos en Cartagena</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Paso 1 -->
                <div class="bg-white text-gray-800 rounded-2xl p-4">
                    <img src="{{ asset('images/home/circle-1.png') }}" alt="1" class="w-6 h-6 mb-3">
                    <div class="w-14 h-14 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-xl">📄</div>
                    <h4 class="text-lg font-bold mb-2">Envíanos tus Datos</h4>
                    <p class="text-gray-600 text-sm mb-4">Llena el formulario online con tus datos básicos y documentos requeridos.</p>
                    <h5 class="font-bold text-sm mb-2">Documentos requeridos</h5>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Cédula de ciudadanía</li>
                        <li>• Licencia de conducción</li>
                        <li>• Referencias personales</li>
                    </ul>
                </div>

                <!-- Paso 2 -->
                <div class="bg-white text-gray-800 rounded-2xl p-4">
                    <img src="{{ asset('images/home/circle-2.png') }}" alt="2" class="w-6 h-6 mb-3">
                    <div class="w-14 h-14 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-xl">✓</div>
                    <h4 class="text-lg font-bold mb-2">Aprobación de Datos</h4>
                    <p class="text-gray-600 text-sm mb-4">Nuestro equipo verifica tu información en máximo 24-48 horas.</p>
                    <h5 class="font-bold text-sm mb-2">Proceso realizado</h5>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Verificación de datos</li>
                        <li>• Aprobación crediticia</li>
                        <li>• Confirmación disponibilidad</li>
                    </ul>
                </div>

                <!-- Paso 3 -->
                <div class="bg-white text-gray-800 rounded-2xl p-4">
                    <img src="{{ asset('images/home/circle-3.png') }}" alt="3" class="w-6 h-6 mb-3">
                    <div class="w-14 h-14 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-xl">🎓</div>
                    <h4 class="text-lg font-bold mb-2">Escuela Renting365</h4>
                    <p class="text-gray-600 text-sm mb-4">Recibe tu formación inicial para comenzar a generar ingresos.</p>
                    <h5 class="font-bold text-sm mb-2">Incluye Charlas</h5>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Seguridad Vial</li>
                        <li>• Plan Emprendedor</li>
                        <li>• Servicio al Cliente y Finanzas</li>
                    </ul>
                </div>

                <!-- Paso 4 -->
                <div class="bg-white text-gray-800 rounded-2xl p-4">
                    <img src="{{ asset('images/home/circle-4.png') }}" alt="4" class="w-6 h-6 mb-3">
                    <div class="w-14 h-14 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-xl">🏍️</div>
                    <h4 class="text-lg font-bold mb-2">Recibe tu Moto</h4>
                    <p class="text-gray-600 text-sm mb-4">Te entregamos la moto con toda la documentación y capacitación incluida.</p>
                    <h5 class="font-bold text-sm mb-2">Esto Incluye</h5>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Entrega de Vehículo</li>
                        <li>• Documentos en regla</li>
                        <li>• Inducción completa</li>
                    </ul>
                </div>

                <!-- Paso 5 -->
                <div class="bg-white text-gray-800 rounded-2xl p-4">
                    <img src="{{ asset('images/home/circle-5.png') }}" alt="5" class="w-6 h-6 mb-3">
                    <div class="w-14 h-14 mx-auto mb-3 bg-orange-600 rounded-full flex items-center justify-center text-white text-xl">📈</div>
                    <h4 class="text-lg font-bold mb-2">¡Empieza a generar!</h4>
                    <p class="text-gray-600 text-sm mb-4">Comienza a trabajar y generar ingresos desde el primer día.</p>
                    <h5 class="font-bold text-sm mb-2">Beneficios Incluidos</h5>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Soporte 24/7</li>
                        <li>• Seguro contra accidentes</li>
                        <li>• GPS</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Escuela Renting365 Detallada Section -->
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-3xl font-bold mb-4">Escuela <span class="brand-gradient">Renting365</span></h3>
                    <p class="text-gray-700 mb-6">Te preparamos para crecer: recibirás formación en Seguridad Vial, Emprendimiento, Servicio al Cliente y Finanzas, junto a un acompañamiento integral para tu desarrollo personal y profesional.</p>
                    
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <span class="text-orange-600 font-bold text-xl">1.</span>
                            <div>
                                <h5 class="font-bold mb-1">Charla con Psicólogo:</h5>
                                <p class="text-gray-600">Sesión de bienvenida con un psicólogo para conocerte y definir tus objetivos.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="text-orange-600 font-bold text-xl">2.</span>
                            <div>
                                <h5 class="font-bold mb-1">Seguridad Vial:</h5>
                                <p class="text-gray-600">Revisión de normas básicas, conducción responsable y buenas prácticas para moverte con seguridad en la ciudad.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="text-orange-600 font-bold text-xl">3.</span>
                            <div>
                                <h5 class="font-bold mb-1">Plan Emprendedor:</h5>
                                <p class="text-gray-600">Guía práctica para estructurar tu plan de trabajo y generar ingresos con tu moto (pedidos propios o servicios locales).</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="text-orange-600 font-bold text-xl">4.</span>
                            <div>
                                <h5 class="font-bold mb-1">Manejo de sus Finanzas:</h5>
                                <p class="text-gray-600">Herramientas simples para organizar gastos, separar utilidades y proyectar metas de ahorro.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="text-orange-600 font-bold text-xl">5.</span>
                            <div>
                                <h5 class="font-bold mb-1">Servicio al Cliente:</h5>
                                <p class="text-gray-600">Consejos para una atención cordial, comunicación efectiva y resolución de inconvenientes.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center">
                    <img src="{{ asset('images/home/muneco-renting365.webp') }}" alt="Escuela Renting365" class="max-w-md w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Club Renting365 Section -->
    <section class="py-10 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div class="p-6 md:p-8">
                        <div class="inline-block bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-semibold mb-3">
                            ⭐ Exclusivo para Clientes
                        </div>
                        <h3 class="text-3xl font-bold mb-3">Únete al <span class="text-orange-600">CLUB<br>Renting365</span></h3>
                        <p class="text-gray-700 mb-4">La comunidad de nuestros clientes, con noticias útiles, alertas de movilidad y precios preferenciales en mantenimiento podrás enviar tu CV para que las empresas puedan ver tu perfil, incluido con tu plan Renting365.</p>
                        
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center gap-2">
                                <span class="text-orange-600 text-xl">👥</span>
                                <span class="text-sm font-medium">Comunidad exclusiva</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-orange-600 text-xl">🔔</span>
                                <span class="text-sm font-medium">Alertas en tiempo real</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-orange-600 text-xl">🔧</span>
                                <span class="text-sm font-medium">Descuentos especiales</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-full">
                        <img src="{{ asset('images/home/club-renting365.webp') }}" alt="Club Renting365" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Motos Section -->
    <section id="motos" class="py-10 bg-white relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold mb-3">Nuestras Motos</h3>
                <p class="text-gray-600">Encuentra la moto perfecta para trabajar. Todas nuestras motos incluyen<br>mantenimiento, seguro y soporte técnico las 24 horas.</p>
            </div>
            
            <div class="max-w-md mx-auto">
                <!-- AUTECO TVS Sport 100 -->
                <div class="bg-gradient-to-br from-orange-50 to-white rounded-2xl p-6 shadow-xl text-center">
                    <img src="{{ asset('images/home/AUTECO-TVS-Sport-100.png') }}" alt="AUTECO TVS Sport 100" class="w-full max-h-64 object-contain mb-4">
                    <h4 class="text-2xl font-bold mb-2">AUTECO TVS Sport 100</h4>
                    <div class="border-t-2 border-orange-200 my-3"></div>
                    <p class="text-3xl font-bold text-orange-600 mb-4">$35.000 <span class="text-sm text-gray-600 font-normal">/ Diarios</span></p>
                    <div class="flex flex-col gap-2">
                        <a href="https://api.whatsapp.com/send?phone=573145144067&text=Hola!%20Estoy%20interesado%20en%20adquirir%20junto%20a%20Renting365%20una%20moto%20AUTECO%20TVS%20Sport%20100.%20%C2%BFPodr%C3%ADan%20darme%20m%C3%A1s%20informaci%C3%B3n%3F" target="_blank" class="px-6 py-3 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700 transition">Reservar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-10 bg-gradient-to-br from-orange-500 to-orange-600 text-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold mb-2">500+</div>
                    <p class="text-xl">Motos en Renting</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">1000+</div>
                    <p class="text-xl">Clientes Satisfechos</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">24/7</div>
                    <p class="text-xl">Soporte Técnico</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios Section -->
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold mb-3">Testimonios de Éxito</h3>
                <p class="text-gray-600">Conoce las experiencias reales de nuestros clientes que han transformado sus vidas<br>generando ingresos con Renting365.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition">
                    <img src="{{ asset('images/home/testimonio1.png') }}" alt="Testimonio 1" class="w-full h-auto">
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition">
                    <img src="{{ asset('images/home/testimonio2.png') }}" alt="Testimonio 2" class="w-full h-auto">
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition">
                    <img src="{{ asset('images/home/testimonio3.png') }}" alt="Testimonio 3" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-10 bg-gradient-to-br from-orange-500 to-orange-600">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold mb-3 text-white">Preguntas Frecuentes</h3>
                <p class="text-white">Preguntas claras, respuestas rápidas: sin letras pequeñas ni costos ocultos.</p>
            </div>

            <div class="space-y-3">
                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>1. ¿Qué es Renting365 y cómo funciona su modelo?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">Renting365 te ofrece un modelo de acceso a una motocicleta para trabajar de forma segura y sostenible. Desde el primer día, la moto se registra a tu nombre con una prenda de garantía a favor de Renting365. Pagas una cuota diaria por el uso o semanal, al finalizar el contrato, la moto es completamente tuya. Además, hacemos parte de un ecosistema integral que te protege y te impulsa.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>2. ¿Cuál es la inversión inicial para acceder a una motocicleta de Renting365?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">Debes realizar un pago inicial que incluye un aporte para el Fondo de Siniestralidad, equivalente al 10% del valor de la moto. Este fondo es clave para tu seguridad financiera. También cubrimos otros gastos iniciales como los seguros obligatorios.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>3. ¿Qué incluye el pago de la cuota diaria de $35.000 COP?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">La cuota diaria de $35.000 COP cubre el valor base por el uso de la motocicleta, así como el IVA aplicable (calculado de forma especial para renting), el aporte recurrente a tu Fondo de Siniestralidad y los seguros correspondientes (SOAT, Seguro de Vida, Seguro Todo Riesgo y Asistencia Jurídica).</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>4. ¿Qué beneficios tengo al ser parte de Renting365 y del Club Renting365?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="mt-4 text-gray-600">
                        <p class="mb-2">Más allá de tener tu propia moto para trabajar, accedes a un ecosistema integral:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Fondo de Siniestralidad:</strong> Te cubre las cuotas en caso de incapacidad temporal por accidente.</li>
                            <li><strong>Escuela Renting365:</strong> Capacitación obligatoria y gratuita en seguridad vial, emprendimiento y servicio al cliente y mejor manejo de tus finanzas.</li>
                            <li><strong>Club Renting365:</strong> Descuentos exclusivos en repuestos, lubricantes y llantas, acceso a una bolsa de empleo para domiciliarios y otros apoyos. Podrás enviar tu CV para que te ayudemos a buscar oportunidades laborales.</li>
                            <li><strong>Seguros Adicionales:</strong> Tienes acceso a seguro todo riesgo y seguro de vida, brindándote una protección completa.</li>
                        </ul>
                    </div>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>5. ¿Qué pasa si sufro un accidente y no puedo trabajar?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">Si sufres un accidente que te incapacita temporalmente, el Fondo de Siniestralidad de Renting 365 cubrirá tus cuotas diarias durante un periodo determinado (previo cumplimiento de los requisitos), permitiéndote recuperarte sin preocuparte por los pagos y el riesgo de perder tu moto.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>6. ¿Es obligatorio tomar la capacitación de la Escuela Renting365?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">Sí, la capacitación en la Escuela Renting365 es obligatoria. Está diseñada para mejorar tu seguridad en la vía, optimizar tu trabajo y potenciar tus ingresos. Es una inversión en tu propio desarrollo.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>7. ¿Cuáles son los requisitos para acceder a una motocicleta con Renting365?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">Además del pago inicial, debes cumplir con los requisitos de la Escuela Renting365 y el perfil de riesgo establecido por Renting365 (esto puede incluir revisión de historial crediticio, entrevista, etc.). Toda la documentación necesaria te será solicitada durante el proceso de aplicación.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>8. ¿Renting365 es legal y paga sus impuestos?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">Sí, Renting365 opera bajo todas las leyes colombianas y cumple rigurosamente con sus obligaciones tributarias, incluyendo el pago de IVA e Impuesto de Renta. Somos una empresa formal y comprometida con el desarrollo de la economía local. Esto te garantiza confianza y transparencia en todos nuestros procesos.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-6 cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 list-none flex justify-between items-center">
                        <span>9. ¿Qué sucede si no puedo continuar pagando las cuotas diarias?</span>
                        <span class="text-orange-600 text-2xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-4 text-gray-600">En caso de que tengas dificultades para continuar con los pagos, podrás solicitar autorización a Renting365 para ceder tu cupo a otra persona que cumpla con los requisitos del programa. De esta manera, podrás llegar a una negociación privada con el nuevo tomador del cupo sobre el monto que has cancelado anteriormente, permitiendo recuperar tu inversión y evitando la pérdida del acuerdo.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- Mapa Section -->
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold mb-3">Nuestra Cobertura</h3>
                <p class="text-gray-600"><span class="text-orange-600 font-bold">Cartagena</span> es nuestro punto de partida. Muy pronto también en <strong><span class="text-orange-600">Barranquilla</span></strong>, <span class="text-orange-600"><strong>Santa Marta</strong></span> y<br>demás Ciudades del país. Este es apenas el comienzo de nuestra ruta por Colombia.</p>
            </div>
            
            <div class="max-w-5xl mx-auto">
                <div class="bg-gray-200 rounded-2xl overflow-hidden shadow-xl" style="height: 500px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125825.84035633948!2d-75.56359!3d10.39972!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8ef625d1e5d0a28f%3A0x6e36c7a5e9e5e5e5!2sCartagena%2C%20Bol%C3%ADvar%2C%20Colombia!5e0!3m2!1ses!2sco!4v1234567890" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <div class="mt-6 grid md:grid-cols-3 gap-4 text-center">
                    <div class="bg-orange-50 rounded-xl p-6">
                        <div class="text-3xl mb-2">📍</div>
                        <h4 class="font-bold text-lg mb-2">Cartagena</h4>
                        <p class="text-gray-600 text-sm">Disponible ahora</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="text-3xl mb-2">🕒</div>
                        <h4 class="font-bold text-lg mb-2">Barranquilla</h4>
                        <p class="text-gray-600 text-sm">Próximamente</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <div class="text-3xl mb-2">🕒</div>
                        <h4 class="font-bold text-lg mb-2">Santa Marta</h4>
                        <p class="text-gray-600 text-sm">Próximamente</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solicitud de Financiamiento Section -->
    <section id="financiamiento" class="py-10 bg-gradient-to-br from-orange-600 via-orange-500 to-orange-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">🏍️ ¡Obtén tu Moto Ahora!</h2>
                <p class="text-lg text-white/90 max-w-3xl mx-auto">Completa el formulario y un asesor se contactará contigo en menos de 24 horas. Sin complicaciones, proceso rápido y seguro.</p>
            </div>

            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-6 md:p-8">
                @livewire('credit-application-form')
            </div>

            <div class="mt-8 grid md:grid-cols-3 gap-4 text-white text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">⚡</div>
                    <h4 class="font-bold text-lg mb-1">Respuesta Rápida</h4>
                    <p class="text-white/80 text-sm">En menos de 24 horas</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">💰</div>
                    <h4 class="font-bold text-lg mb-1">Planes Flexibles</h4>
                    <p class="text-white/80 text-sm">Desde 6 hasta 24 meses</p>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">✅</div>
                    <h4 class="font-bold text-lg mb-1">Aprobación Fácil</h4>
                    <p class="text-white/80 text-sm">Requisitos mínimos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <!-- Grupo Contigo Section -->
        <div class="bg-gray-800 py-8">
            <div class="container mx-auto px-4 text-center">
                <h3 class="text-xl font-bold mb-4">Hacemos Parte de:</h3>
                <img src="{{ asset('images/home/grupocontigo-white-logo200px.webp') }}" alt="Grupo Contigo" class="h-16 mx-auto">
            </div>
        </div>
        
        <!-- Main Footer -->
        <div class="py-12">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-4 text-orange-500">RENTING365</h3>
                        <p class="text-gray-400">Facilita tu vida con nuestro servicio de renting de motos</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Enlaces</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#inicio" class="hover:text-white">Inicio</a></li>
                            <li><a href="#planes" class="hover:text-white">Planes</a></li>
                            <li><a href="#motos" class="hover:text-white">Motos</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Contacto</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li>+57 314 5144067</li>
                            <li>Cartagena, Colombia</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Síguenos</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-orange-500">Facebook</a>
                            <a href="#" class="text-gray-400 hover:text-orange-500">Instagram</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="bg-black py-6">
            <div class="container mx-auto px-4 text-center">
                <h4 class="text-xl font-bold mb-2">RENTING365.CO</h4>
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Renting365.co - Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    

    <!-- Convocatoria Widget -->
    <div id="convocatoria-widget" class="fixed bottom-24 sm:bottom-28 left-4 sm:left-8 z-50 max-w-xs">
        <div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-2xl shadow-2xl p-4 animate-bounce-slow">
            <button id="close-convocatoria" class="absolute -top-2 -right-2 w-6 h-6 bg-white rounded-full shadow-lg flex items-center justify-center text-orange-600 hover:bg-gray-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center animate-pulse">
                        <span class="text-2xl">🏍️</span>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">NUEVO</span>
                        <span class="text-white text-xs font-semibold">¡CONVOCATORIA ABIERTA!</span>
                    </div>
                    <h4 class="text-white font-bold text-sm mb-2">Primeras 10 Motos Disponibles</h4>
                    <p class="text-white text-xs mb-2 opacity-90">Sé parte de los primeros en Cartagena. ¡Cupos limitados!</p>
                    <div class="flex items-center gap-1 mb-3">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-white text-xs font-semibold">Cierre de convocatoria: 10 de Noviembre</span>
                    </div>
                    <a href="#financiamiento" class="block w-full bg-white text-orange-600 text-center text-sm font-bold py-2 px-4 rounded-full hover:bg-gray-100 transition shadow-lg">
                        ¡Quiero mi Moto! 🚀
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chatbot Widget -->
    <div id="chatbot-widget" class="fixed bottom-6 sm:bottom-8 right-4 sm:right-8 z-50">
        <button id="chatbot-toggle" class="w-12 h-12 sm:w-14 sm:h-14 bg-orange-600 rounded-full shadow-lg flex items-center justify-center text-white hover:bg-orange-700 transition">
            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        </button>
        
        <div id="chatbot-window" class="hidden absolute bottom-16 right-0 w-[calc(100vw-2rem)] sm:w-96 max-w-md h-[500px] bg-white rounded-2xl shadow-2xl flex flex-col">
            <div class="bg-orange-600 text-white p-4 rounded-t-2xl flex justify-between items-center">
                <h3 class="font-bold">Asistente Renting365</h3>
                <button id="chatbot-close" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div id="chatbot-messages" class="flex-1 overflow-y-auto p-4 space-y-3">
                <div class="bg-gray-100 rounded-lg p-3 max-w-[80%]">
                    <p class="text-sm">¡Hola! 👋 Soy tu asistente virtual de Renting365.</p>
                    <p class="text-sm mt-2">Puedo ayudarte con información sobre planes, requisitos, motos y más.</p>
                    <p class="text-sm mt-2">¿En qué puedo ayudarte hoy?</p>
                </div>
            </div>
            
            <div class="p-4 border-t">
                <form id="chatbot-form" class="flex gap-2">
                    <input type="text" id="chatbot-input" placeholder="Escribe tu mensaje..." class="flex-1 px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-orange-600">
                    <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-full hover:bg-orange-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }
        #convocatoria-widget {
            transition: opacity 0.3s, transform 0.3s;
        }
        #convocatoria-widget.hidden {
            opacity: 0;
            transform: translateX(-100%);
            pointer-events: none;
        }
    </style>

    <script>
        // Convocatoria Widget
        const convocatoriaWidget = document.getElementById('convocatoria-widget');
        const closeConvocatoria = document.getElementById('close-convocatoria');
        
        closeConvocatoria.addEventListener('click', (e) => {
            e.preventDefault();
            convocatoriaWidget.classList.add('hidden');
        });
        
        // Cerrar al hacer clic en el botón de acción
        convocatoriaWidget.querySelector('a').addEventListener('click', () => {
            setTimeout(() => {
                convocatoriaWidget.classList.add('hidden');
                sessionStorage.setItem('convocatoriaClosed', 'true');
            }, 500);
        });

        // Chatbot
        const sessionId = 'session-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        const toggle = document.getElementById('chatbot-toggle');
        const closeBtn = document.getElementById('chatbot-close');
        const chatWindow = document.getElementById('chatbot-window');
        const form = document.getElementById('chatbot-form');
        const input = document.getElementById('chatbot-input');
        const messages = document.getElementById('chatbot-messages');

        toggle.addEventListener('click', () => {
            chatWindow.classList.toggle('hidden');
            if (!chatWindow.classList.contains('hidden')) {
                input.focus();
            }
        });

        closeBtn.addEventListener('click', () => {
            chatWindow.classList.add('hidden');
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            addMessage(message, 'user');
            input.value = '';

            const typingDiv = document.createElement('div');
            typingDiv.className = 'bg-gray-100 rounded-lg p-3 max-w-[80%]';
            typingDiv.id = 'typing-indicator';
            typingDiv.innerHTML = '<p class="text-sm text-gray-500"><span class="typing-dots">Pensando<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></span></p>';
            messages.appendChild(typingDiv);
            messages.scrollTop = messages.scrollHeight;

            await new Promise(resolve => setTimeout(resolve, 800));

            try {
                const response = await fetch('{{ route('chatbot.message') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                
                await new Promise(resolve => setTimeout(resolve, 600));
                
                document.getElementById('typing-indicator')?.remove();
                
                if (data.success && data.message) {
                    addMessage(data.message, 'bot');
                    
                    if (data.action && data.action.type === 'redirect') {
                        setTimeout(() => {
                            window.open(data.action.url, '_blank');
                        }, data.action.delay || 2000);
                    }
                } else {
                    addMessage('Lo siento, hubo un error. Por favor intenta de nuevo.', 'bot');
                }
            } catch (error) {
                document.getElementById('typing-indicator')?.remove();
                addMessage('Error de conexión. Por favor intenta más tarde.', 'bot');
            }
        });

        function addMessage(text, sender) {
            const div = document.createElement('div');
            div.className = sender === 'user' 
                ? 'bg-orange-600 text-white rounded-lg p-3 max-w-[80%] ml-auto' 
                : 'bg-gray-100 rounded-lg p-3 max-w-[80%]';
            
            const formattedText = text.replace(/\n/g, '<br>');
            div.innerHTML = `<p class="text-sm whitespace-pre-line">${formattedText}</p>`;
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }
    </script>
</body>
</html>
