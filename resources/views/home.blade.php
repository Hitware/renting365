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
                <span>📞 +57 310 5367376</span>
                <span>📍 Cartagena, Colombia</span>
            </div>
            <div class="hidden sm:block">¡Renta tu moto hoy mismo!</div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <img src="{{ asset('images/home/logo_renting.png') }}" alt="Renting365" class="h-8 sm:h-10 md:h-12" style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
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
            <img src="{{ asset('images/home/hero-bg.png') }}" alt="Hero Background" class="w-full h-full object-cover object-[70%_center] sm:object-center">
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
                <a href="https://api.whatsapp.com/send?phone=573105367376&text=Hola!%20👋%20Estoy%20interesado%20en%20adquirir%20una%20moto%20con%20Renting365" class="w-full sm:w-auto px-8 py-3 sm:px-10 sm:py-4 bg-green-600 text-white rounded-full hover:bg-green-700 transition-all text-base sm:text-lg font-semibold shadow-2xl">Hablar con un Asesor</a>
            </div>
        </div>
    </section>

    <!-- Planes Section -->
    <section id="planes" class="py-6 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h3 class="text-2xl sm:text-3xl font-bold mb-2">Planes Disponibles</h3>
                <p class="text-xs sm:text-sm text-gray-600 max-w-3xl mx-auto">Encuentra la moto perfecta para trabajar. Todas nuestras motos incluyen mantenimiento, seguro y soporte técnico las 24 horas.</p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                <!-- Plan Delivery -->
                <div class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition">
                    <img src="{{ asset('images/home/img-delivery.png') }}" alt="Plan Delivery" class="w-full mb-3">
                    <h3 class="text-xl font-bold text-center mb-2">Plan Delivery</h3>
                    <p class="text-center text-orange-600 font-semibold mb-3 text-sm">Tu llave de acceso a las plataformas y la logística</p>
                    <p class="text-justify text-gray-700 mb-3 leading-relaxed text-xs">¡El trabajo en plataformas como Rappi, Didi, Droguerías, Restaurantes y empresas de distribución te espera! Para acceder a esas oportunidades, necesitas un vehículo confiable y seguro. El Plan Delivery de <strong>Renting365</strong> es tu solución: adquiere tu moto desde el primer día con nuestro respaldo integral.</p>
                    <a href="#quiero-mi-moto" class="block w-full px-5 py-2.5 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700 transition text-sm">Comienza hoy</a>
                </div>

                <!-- Plan Universitario -->
                <div class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition">
                    <img src="{{ asset('images/home/img-student.png') }}" alt="Plan Universitario" class="w-full mb-3">
                    <h3 class="text-xl font-bold text-center mb-2">Plan Universitario</h3>
                    <p class="text-center text-orange-600 font-semibold mb-3 text-sm">Movilidad inteligente para tu futuro</p>
                    <p class="text-justify text-gray-700 mb-3 leading-relaxed text-xs">La universidad es el camino hacia tus sueños, y el Plan Universitario te da la libertad de moverte sin límites mientras lo recorres. Olvídate del transporte público y de llegar tarde. Adquiere tu moto desde el primer día con <strong>Renting365</strong>.</p>
                    <a href="#quiero-mi-moto" class="block w-full px-5 py-2.5 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700 transition text-sm">Descubre cómo</a>
                </div>

                <!-- Plan Emprendedor -->
                <div class="bg-white rounded-xl shadow-lg p-4 hover:shadow-xl transition">
                    <img src="{{ asset('images/home/img-trabajador.png') }}" alt="Plan Emprendedor" class="w-full mb-3">
                    <h3 class="text-xl font-bold text-center mb-2">Plan Emprendedor</h3>
                    <p class="text-center text-orange-600 font-semibold mb-3 text-sm">Impulsa tu negocio con Renting365</p>
                    <p class="text-justify text-gray-700 mb-3 leading-relaxed text-xs">Todo gran negocio necesita un impulso, y el Plan Emprendedor está diseñado para darle alas a tu proyecto. Obtén la moto que necesitas con nuestro respaldo integral de <strong>Renting365</strong>. Con el Club Renting365, tienes descuentos en mantenimiento.</p>
                    <a href="#quiero-mi-moto" class="block w-full px-5 py-2.5 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700 transition text-sm">Conoce los beneficios</a>
                </div>
            </div>

            <div class="bg-orange-50 rounded-xl p-4 text-center">
                <p class="text-gray-800 text-sm"><strong>Lo que incluye:</strong> SOAT, Seguro de Vida, Seguro Todo Riesgo, Fondo de Siniestralidad y Asistencia Jurídica. ¿Tienes preguntas? Te acompañamos en cada paso. 👇</p>
            </div>
        </div>
    </section>

    <!-- Beneficios Section -->
    <section class="py-6 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h3 class="text-2xl sm:text-3xl font-bold mb-2">Beneficios Incluidos<br>Con <span class="brand-gradient">Renting365</span></h3>
                <p class="text-gray-600 text-xs sm:text-sm">Todo esto viene con tu moto desde el primer día.<br>Sin costos ocultos, sin letra pequeña.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-4 max-w-5xl mx-auto">
                <div class="bg-white rounded-lg p-4 shadow-md flex items-start gap-3 hover:shadow-lg transition w-full sm:w-[calc(50%-0.5rem)] lg:w-[calc(33.333%-0.67rem)]">
                    <img src="{{ asset('images/home/icon-soat.webp') }}" alt="SOAT" class="w-12 h-12 flex-shrink-0">
                    <div>
                        <h4 class="text-base font-bold mb-1">SOAT Incluido ✓</h4>
                        <p class="text-gray-600 text-xs">Seguro obligatorio de accidentes de tránsito incluido.</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-md flex items-start gap-3 hover:shadow-lg transition w-full sm:w-[calc(50%-0.5rem)] lg:w-[calc(33.333%-0.67rem)]">
                    <img src="{{ asset('images/home/icon-seguro-vida.webp') }}" alt="Seguro de Vida" class="w-12 h-12 flex-shrink-0">
                    <div>
                        <h4 class="text-base font-bold mb-1">Seguro de Vida ✓</h4>
                        <p class="text-gray-600 text-xs">Cobertura de vida para tu tranquilidad.</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-md flex items-start gap-3 hover:shadow-lg transition w-full sm:w-[calc(50%-0.5rem)] lg:w-[calc(33.333%-0.67rem)]">
                    <img src="{{ asset('images/home/icon-todo-riesgo.webp') }}" alt="Todo Riesgo" class="w-12 h-12 flex-shrink-0">
                    <div>
                        <h4 class="text-base font-bold mb-1">Seguro Todo Riesgo ✓</h4>
                        <p class="text-gray-600 text-xs">Protege tu inversión en caso de perdida total o robo.</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-md flex items-start gap-3 hover:shadow-lg transition w-full sm:w-[calc(50%-0.5rem)] lg:w-[calc(33.333%-0.67rem)]">
                    <img src="{{ asset('images/home/icon-siniestralidad.webp') }}" alt="Fondo Siniestralidad" class="w-12 h-12 flex-shrink-0">
                    <div>
                        <h4 class="text-base font-bold mb-1">Fondo de Siniestralidad ✓</h4>
                        <p class="text-gray-600 text-xs">Protección financiera en caso de accidentes.</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-md flex items-start gap-3 hover:shadow-lg transition w-full sm:w-[calc(50%-0.5rem)] lg:w-[calc(33.333%-0.67rem)]">
                    <img src="{{ asset('images/home/icon-todo-riesgo.webp') }}" alt="Asistencia Jurídica" class="w-12 h-12 flex-shrink-0">
                    <div>
                        <h4 class="text-base font-bold mb-1">Asistencia Jurídica ✓</h4>
                        <p class="text-gray-600 text-xs">Asesoría legal cuando lo necesites.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo Funciona Section -->
    <section class="py-6 bg-gradient-to-br from-orange-500 to-orange-600 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h3 class="text-2xl sm:text-3xl font-bold mb-2">¿Cómo Funciona?</h3>
                <p class="text-xs sm:text-sm">Un proceso sencillo y rápido para que comiences a generar ingresos en Cartagena</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Paso 1 -->
                <div class="bg-white text-gray-800 rounded-xl p-3">
                    <img src="{{ asset('images/home/circle-1.png') }}" alt="1" class="w-5 h-5 mb-2">
                    <div class="w-12 h-12 mx-auto mb-2 bg-orange-600 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                    </div>
                    <h4 class="text-base font-bold mb-1.5">Envíanos tus Datos</h4>
                    <p class="text-gray-600 text-xs mb-2">Llena el formulario online con tus datos básicos y documentos requeridos.</p>
                    <h5 class="font-bold text-xs mb-1.5">Documentos requeridos</h5>
                    <ul class="text-[10px] text-gray-600 space-y-0.5">
                        <li>• Cédula de ciudadanía</li>
                        <li>• Licencia de conducción</li>
                        <li>• Referencias personales</li>
                    </ul>
                </div>

                <!-- Paso 2 -->
                <div class="bg-white text-gray-800 rounded-xl p-3">
                    <img src="{{ asset('images/home/circle-2.png') }}" alt="2" class="w-5 h-5 mb-2">
                    <div class="w-12 h-12 mx-auto mb-2 bg-orange-600 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/></svg>
                    </div>
                    <h4 class="text-base font-bold mb-1.5">Aprobación de Datos</h4>
                    <p class="text-gray-600 text-xs mb-2">Nuestro equipo verifica tu información en máximo 24-48 horas.</p>
                    <h5 class="font-bold text-xs mb-1.5">Proceso realizado</h5>
                    <ul class="text-[10px] text-gray-600 space-y-0.5">
                        <li>• Verificación de datos</li>
                        <li>• Validación financiera</li>
                        <li>• Confirmación disponibilidad</li>
                    </ul>
                </div>

                <!-- Paso 3 -->
                <div class="bg-white text-gray-800 rounded-xl p-3">
                    <img src="{{ asset('images/home/circle-3.png') }}" alt="3" class="w-5 h-5 mb-2">
                    <div class="w-12 h-12 mx-auto mb-2 bg-orange-600 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 01.6 0A60.65 60.65 0 0122.83 8.72a.75.75 0 01-.231 1.337 49.949 49.949 0 00-9.902 3.912l-.003.002-.34.18a.75.75 0 01-.707 0A50.009 50.009 0 007.5 12.174v-.224c0-.131.067-.248.172-.311a54.614 54.614 0 014.653-2.52.75.75 0 00-.65-1.352 56.129 56.129 0 00-4.78 2.589 1.858 1.858 0 00-.859 1.228 49.803 49.803 0 00-4.634-1.527.75.75 0 01-.231-1.337A60.653 60.653 0 0111.7 2.805z"/><path d="M13.06 15.473a48.45 48.45 0 017.666-3.282c.134 1.414.22 2.843.255 4.285a.75.75 0 01-.46.71 47.878 47.878 0 00-8.105 4.342.75.75 0 01-.832 0 47.877 47.877 0 00-8.104-4.342.75.75 0 01-.461-.71c.035-1.442.121-2.87.255-4.286A48.4 48.4 0 016 13.18v1.27a1.5 1.5 0 00-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.661a6.729 6.729 0 00.551-1.608 1.5 1.5 0 00.14-2.67v-.645a48.549 48.549 0 013.44 1.668 2.25 2.25 0 002.12 0z"/><path d="M4.462 19.462c.42-.419.753-.89 1-1.394.453.213.902.434 1.347.661a6.743 6.743 0 01-1.286 1.794.75.75 0 11-1.06-1.06z"/></svg>
                    </div>
                    <h4 class="text-base font-bold mb-1.5">Escuela Renting365</h4>
                    <p class="text-gray-600 text-xs mb-2">Recibe tu formación inicial para comenzar a generar ingresos.</p>
                    <h5 class="font-bold text-xs mb-1.5">Incluye Charlas</h5>
                    <ul class="text-[10px] text-gray-600 space-y-0.5">
                        <li>• Seguridad Vial</li>
                        <li>• Plan Emprendedor</li>
                        <li>• Servicio al Cliente y Finanzas</li>
                    </ul>
                </div>

                <!-- Paso 4 -->
                <div class="bg-white text-gray-800 rounded-xl p-3">
                    <img src="{{ asset('images/home/circle-4.png') }}" alt="4" class="w-5 h-5 mb-2">
                    <div class="w-12 h-12 mx-auto mb-2 bg-orange-600 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 116 0h3a.75.75 0 00.75-.75V15z"/><path d="M8.25 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0zM15.75 6.75a.75.75 0 00-.75.75v11.25c0 .087.015.17.042.248a3 3 0 015.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 00-3.732-10.104 1.837 1.837 0 00-1.47-.725H15.75z"/><path d="M19.5 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z"/></svg>
                    </div>
                    <h4 class="text-base font-bold mb-1.5">Recibe tu Moto</h4>
                    <p class="text-gray-600 text-xs mb-2">Te entregamos la moto con toda la documentación y capacitación incluida.</p>
                    <h5 class="font-bold text-xs mb-1.5">Esto Incluye</h5>
                    <ul class="text-[10px] text-gray-600 space-y-0.5">
                        <li>• Entrega de Vehículo</li>
                        <li>• Documentos en regla</li>
                        <li>• Inducción completa</li>
                    </ul>
                </div>

                <!-- Paso 5 -->
                <div class="bg-white text-gray-800 rounded-xl p-3">
                    <img src="{{ asset('images/home/circle-5.png') }}" alt="5" class="w-5 h-5 mb-2">
                    <div class="w-12 h-12 mx-auto mb-2 bg-orange-600 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd"/></svg>
                    </div>
                    <h4 class="text-base font-bold mb-1.5">¡Empieza a generar!</h4>
                    <p class="text-gray-600 text-xs mb-2">Comienza a trabajar y generar ingresos desde el primer día.</p>
                    <h5 class="font-bold text-xs mb-1.5">Beneficios Incluidos</h5>
                    <ul class="text-[10px] text-gray-600 space-y-0.5">
                        <li>• Soporte 24/7</li>
                        <li>• Seguro contra accidentes</li>
                        <li>• GPS</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Escuela Renting365 Detallada Section -->
    <section class="py-6 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-[1.5fr,1fr] gap-4 items-center">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold mb-2">Escuela <span class="brand-gradient">Renting365</span></h3>
                    <p class="text-gray-700 mb-3 text-xs sm:text-sm">Te preparamos para crecer: recibirás formación en Seguridad Vial, Emprendimiento, Servicio al Cliente y Finanzas.</p>
                    
                    <div class="space-y-1.5">
                        <div class="flex gap-1.5">
                            <span class="text-orange-600 font-bold text-base flex-shrink-0">1.</span>
                            <div>
                                <h5 class="font-bold text-xs mb-0.5">Charla con Psicólogo:</h5>
                                <p class="text-gray-600 text-[11px]">Sesión de bienvenida para conocerte y definir tus objetivos.</p>
                            </div>
                        </div>

                        <div class="flex gap-1.5">
                            <span class="text-orange-600 font-bold text-base flex-shrink-0">2.</span>
                            <div>
                                <h5 class="font-bold text-xs mb-0.5">Seguridad Vial:</h5>
                                <p class="text-gray-600 text-[11px]">Normas básicas y conducción responsable para moverte con seguridad.</p>
                            </div>
                        </div>

                        <div class="flex gap-1.5">
                            <span class="text-orange-600 font-bold text-base flex-shrink-0">3.</span>
                            <div>
                                <h5 class="font-bold text-xs mb-0.5">Plan Emprendedor:</h5>
                                <p class="text-gray-600 text-[11px]">Guía práctica para estructurar tu plan de trabajo y generar ingresos.</p>
                            </div>
                        </div>

                        <div class="flex gap-1.5">
                            <span class="text-orange-600 font-bold text-base flex-shrink-0">4.</span>
                            <div>
                                <h5 class="font-bold text-xs mb-0.5">Manejo de Finanzas:</h5>
                                <p class="text-gray-600 text-[11px]">Herramientas para organizar gastos y proyectar metas de ahorro.</p>
                            </div>
                        </div>

                        <div class="flex gap-1.5">
                            <span class="text-orange-600 font-bold text-base flex-shrink-0">5.</span>
                            <div>
                                <h5 class="font-bold text-xs mb-0.5">Servicio al Cliente:</h5>
                                <p class="text-gray-600 text-[11px]">Atención cordial, comunicación efectiva y resolución de inconvenientes.</p>
                            </div>
                        </div>
                        <div class="flex gap-1.5">
                            <span class="text-orange-600 font-bold text-base flex-shrink-0">6.</span>
                            <div>
                                <h5 class="font-bold text-xs mb-0.5">Mantenimiento Preventivo:</h5>
                                <p class="text-gray-600 text-[11px]">Aprende a cuidar tu moto: revisiones básicas y mantenimiento para prolongar su vida útil.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center">
                    <img src="{{ asset('images/home/muneco-renting365.webp') }}" alt="Escuela Renting365" class="max-w-[280px] w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Club Renting365 Section -->
    <section class="py-6 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl p-1" style="background: linear-gradient(to right, #fed7aa, #fed7aa); border: 2.5px dashed #FF5722; border-radius: 1.25rem;">
                <div class="bg-gradient-to-br from-orange-50/90 to-orange-100/90 rounded-2xl p-4 md:p-6">
                    <div class="grid md:grid-cols-[1.4fr,1fr] gap-4 md:gap-5 items-center">
                        <div>
                            <div class="flex items-center gap-1.5 mb-2">
                                <svg class="w-3.5 h-3.5" style="color: #FF5722;" viewBox="0 0 512 512" fill="currentColor"><path d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"/></svg>
                                <span class="font-bold text-xs" style="color: #FF5722;">Exclusivo para Clientes</span>
                            </div>

                            <h2 class="text-xl md:text-2xl font-bold mb-2 leading-tight">
                                Únete al <span style="color: #FF5722;">CLUB<br>Renting365</span>
                            </h2>

                            <p class="text-gray-700 mb-3 text-xs leading-relaxed">
                                La comunidad de nuestros clientes, con noticias útiles, alertas de movilidad y precios preferenciales en mantenimiento podrás enviar tu hoja de vida para que las empresas puedan ver tu perfil.
                            </p>

                            <div class="flex flex-wrap items-center gap-2.5 md:gap-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" style="color: #FF5722;" viewBox="0 0 640 512" fill="currentColor"><path d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm32 32h-64c-17.6 0-33.5 7.1-45.1 18.6 40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64zm-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2zm-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4z"/></svg>
                                    <span class="text-xs font-semibold text-gray-800">Comunidad exclusiva</span>
                                </div>

                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" style="color: #FF5722;" viewBox="0 0 448 512" fill="currentColor"><path d="M439.39 362.29c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71zM67.53 368c21.22-27.97 44.42-74.33 44.53-159.42 0-.2-.06-.38-.06-.58 0-61.86 50.14-112 112-112s112 50.14 112 112c0 .2-.06.38-.06.58.11 85.1 23.31 131.46 44.53 159.42H67.53zM224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64z"/></svg>
                                    <span class="text-xs font-semibold text-gray-800">Alertas en tiempo real</span>
                                </div>

                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" style="color: #FF5722;" viewBox="0 0 512 512" fill="currentColor"><path d="M507.73 109.1c-2.24-9.03-13.54-12.09-20.12-5.51l-74.36 74.36-67.88-11.31-11.31-67.88 74.36-74.36c6.62-6.62 3.43-17.9-5.66-20.16-47.38-11.74-99.55.91-136.58 37.93-39.64 39.64-50.55 97.1-34.05 147.2L18.74 402.76c-24.99 24.99-24.99 65.51 0 90.5 24.99 24.99 65.51 24.99 90.5 0l213.21-213.21c50.12 16.71 107.47 5.68 147.37-34.22 37.07-37.07 49.7-89.32 37.91-136.73zM64 472c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"/></svg>
                                    <span class="text-xs font-semibold text-gray-800">Descuentos especiales</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center md:justify-end">
                            <div class="relative rounded-xl overflow-hidden shadow-lg max-w-[240px]" style="border: 2.5px solid #FF5722;">
                                <img src="{{ asset('images/home/club-renting365.webp') }}" alt="Club Renting365" class="w-full h-auto object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Motos Section -->
    <section id="motos" class="py-6 bg-white relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h3 class="text-2xl sm:text-3xl font-bold mb-2">Nuestras Motos</h3>
                <p class="text-gray-600 text-xs sm:text-sm">Encuentra la moto perfecta para trabajar. Todas nuestras motos incluyen<br>mantenimiento, seguro y soporte técnico las 24 horas.</p>
            </div>

            <div class="max-w-md mx-auto">
                <!-- AUTECO TVS Sport 100 -->
                <div class="bg-gradient-to-br from-orange-50 to-white rounded-xl p-4 shadow-lg text-center">
                    <img src="{{ asset('images/home/AUTECO-TVS-Sport-100-SLE.png') }}" alt="AUTECO TVS Sport 100" class="w-full max-h-48 object-contain mb-3">
                    <h4 class="text-xl font-bold mb-2">AUTECO TVS Sport 100</h4>
                    <div class="border-t-2 border-orange-200 my-2"></div>
                    <p class="text-2xl font-bold text-orange-600 mb-3">$35.000 <span class="text-xs text-gray-600 font-normal">/ Diarios</span></p>
                    <div class="flex flex-col gap-2">
                        <a href="https://api.whatsapp.com/send?phone=573105367376&text=Hola!%20Estoy%20interesado%20en%20adquirir%20junto%20a%20Renting365%20una%20moto%20AUTECO%20TVS%20Sport%20100.%20%C2%BFPodr%C3%ADan%20darme%20m%C3%A1s%20informaci%C3%B3n%3F" target="_blank" class="px-5 py-2.5 bg-orange-600 text-white text-center rounded-full hover:bg-orange-700 transition text-sm">Reservar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-4 bg-gradient-to-br from-orange-500 to-orange-600 text-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-4 text-center">
                <div>
                    <div class="text-3xl font-bold mb-0.5">500+</div>
                    <p class="text-sm">Motos en Renting</p>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-0.5">1000+</div>
                    <p class="text-sm">Clientes Satisfechos</p>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-0.5">24/7</div>
                    <p class="text-sm">Soporte Técnico</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios Section -->
    <section class="py-6 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-4">
                <h3 class="text-2xl sm:text-3xl font-bold mb-1.5">Testimonios de Éxito</h3>
                <p class="text-gray-600 text-xs">Conoce las experiencias reales de nuestros clientes que han transformado sus vidas generando ingresos con Renting365.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-3">
                <div class="rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <img src="{{ asset('images/home/testimonio1.png') }}" alt="Testimonio 1" class="w-full h-auto">
                </div>
                <div class="rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <img src="{{ asset('images/home/testimonio2.png') }}" alt="Testimonio 2" class="w-full h-auto">
                </div>
                <div class="rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <img src="{{ asset('images/home/testimonio3.png') }}" alt="Testimonio 3" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-6 bg-gradient-to-br from-orange-500 to-orange-600">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-6">
                <h3 class="text-2xl sm:text-3xl font-bold mb-2 text-white">Preguntas Frecuentes</h3>
                <p class="text-white text-xs sm:text-sm">Preguntas claras, respuestas rápidas: sin letras pequeñas ni costos ocultos.</p>
            </div>

            <div class="space-y-2">
                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>1. ¿Qué es Renting365 y cómo funciona su modelo?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">Renting365 te ofrece un modelo de acceso a una motocicleta para trabajar de forma segura y sostenible. Desde el primer día, la moto se registra a tu nombre con una prenda de garantía a favor de Renting365. Pagas una cuota diaria por el uso o semanal, al finalizar el contrato, la moto es completamente tuya. Además, hacemos parte de un ecosistema integral que te protege y te impulsa.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>2. ¿Cuál es la inversión inicial para acceder a una motocicleta de Renting365?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">Debes realizar un pago inicial que incluye un aporte para el Fondo de Siniestralidad, equivalente al 10% del valor de la moto. Este fondo es clave para tu seguridad financiera. También cubrimos otros gastos iniciales como los seguros obligatorios.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>3. ¿Qué incluye el pago de la cuota diaria de $35.000 COP?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">La cuota diaria de $35.000 COP cubre el valor base por el uso de la motocicleta, así como el IVA aplicable (calculado de forma especial para renting), el aporte recurrente a tu Fondo de Siniestralidad y los seguros correspondientes (SOAT, Seguro de Vida, Seguro Todo Riesgo y Asistencia Jurídica).</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>4. ¿Qué beneficios tengo al ser parte de Renting365 y del Club Renting365?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="mt-4 text-gray-600">
                        <p class="mb-2">Más allá de tener tu propia moto para trabajar, accedes a un ecosistema integral:</p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Fondo de Siniestralidad:</strong> Te cubre las cuotas en caso de incapacidad temporal por accidente.</li>
                            <li><strong>Escuela Renting365:</strong> Capacitación obligatoria y gratuita en seguridad vial, emprendimiento y servicio al cliente y mejor manejo de tus finanzas.</li>
                            <li><strong>Club Renting365:</strong> Descuentos exclusivos en repuestos, lubricantes y llantas, acceso a una bolsa de empleo para domiciliarios y otros apoyos. Podrás enviar tu hoja de vida para que te ayudemos a buscar oportunidades laborales.</li>
                            <li><strong>Seguros Adicionales:</strong> Tienes acceso a seguro todo riesgo y seguro de vida, brindándote una protección completa.</li>
                        </ul>
                    </div>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>5. ¿Qué pasa si sufro un accidente y no puedo trabajar?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">Si sufres un accidente que te incapacita temporalmente, el Fondo de Siniestralidad de Renting 365 cubrirá tus cuotas diarias durante un periodo determinado (previo cumplimiento de los requisitos), permitiéndote recuperarte sin preocuparte por los pagos y el riesgo de perder tu moto.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>6. ¿Es obligatorio tomar la capacitación de la Escuela Renting365?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">Sí, la capacitación en la Escuela Renting365 es obligatoria. Está diseñada para mejorar tu seguridad en la vía, optimizar tu trabajo y potenciar tus ingresos. Es una inversión en tu propio desarrollo.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>7. ¿Cuáles son los requisitos para acceder a una motocicleta con Renting365?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">Además del pago inicial, debes cumplir con los requisitos de la Escuela Renting365 y el perfil de riesgo establecido por Renting365 (esto puede incluir revisión de historial financiero, entrevista, etc.). Toda la documentación necesaria te será solicitada durante el proceso de aplicación.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>8. ¿Renting365 es legal y paga sus impuestos?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">Sí, Renting365 opera bajo todas las leyes colombianas y cumple rigurosamente con sus obligaciones tributarias, incluyendo el pago de IVA e Impuesto de Renta. Somos una empresa formal y comprometida con el desarrollo de la economía local. Esto te garantiza confianza y transparencia en todos nuestros procesos.</p>
                </details>

                <details class="bg-white rounded-lg shadow-md p-4 cursor-pointer group">
                    <summary class="font-bold text-base text-gray-800 list-none flex justify-between items-center">
                        <span>9. ¿Qué sucede si no puedo continuar pagando las cuotas diarias?</span>
                        <span class="text-orange-600 text-xl group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <p class="mt-3 text-gray-600 text-xs">En caso de que tengas dificultades para continuar con los pagos, podrás solicitar autorización a Renting365 para ceder tu cupo a otra persona que cumpla con los requisitos del programa. De esta manera, podrás llegar a una negociación privada con el nuevo tomador del cupo sobre el monto que has cancelado anteriormente, permitiendo recuperar tu inversión y evitando la pérdida del acuerdo.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- Mapa Section -->
    <section class="py-6 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <h3 class="text-2xl sm:text-3xl font-bold mb-2">Nuestra Cobertura</h3>
                <p class="text-gray-600 text-xs sm:text-sm"><span class="text-orange-600 font-bold">Cartagena</span> es nuestro punto de partida. Muy pronto también en <strong><span class="text-orange-600">Barranquilla</span></strong>, <span class="text-orange-600"><strong>Santa Marta</strong></span> y<br>demás Ciudades del país. Este es apenas el comienzo de nuestra ruta por Colombia.</p>
            </div>

            <div class="max-w-5xl mx-auto">
                <div class="bg-gray-200 rounded-xl overflow-hidden shadow-lg" style="height: 400px;">
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

                <div class="mt-4 grid md:grid-cols-3 gap-3 text-center">
                    <div class="bg-orange-50 rounded-lg p-4">
                        <div class="text-2xl mb-1">📍</div>
                        <h4 class="font-bold text-base mb-1">Cartagena</h4>
                        <p class="text-gray-600 text-xs">Disponible ahora</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-2xl mb-1">🕒</div>
                        <h4 class="font-bold text-base mb-1">Barranquilla</h4>
                        <p class="text-gray-600 text-xs">Próximamente</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-2xl mb-1">🕒</div>
                        <h4 class="font-bold text-base mb-1">Santa Marta</h4>
                        <p class="text-gray-600 text-xs">Próximamente</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solicitud de Financiamiento Section -->
    <section id="quiero-mi-moto" class="py-6 bg-gradient-to-br from-orange-600 via-orange-500 to-orange-600 relative overflow-x-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">🏍️ ¡Obtén tu Moto Ahora!</h2>
                <p class="text-sm text-white/90 max-w-3xl mx-auto">Completa el formulario y un asesor se contactará contigo en menos de 24 horas. Sin complicaciones, proceso rápido y seguro.</p>
            </div>

            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-4 md:p-6" style="overflow: visible;">
                @livewire('credit-application-form')
            </div>

            <div class="mt-6 grid md:grid-cols-3 gap-3 text-white text-center">
                <div>
                    <div class="text-3xl font-bold mb-1">⚡</div>
                    <h4 class="font-bold text-base mb-0.5">Respuesta Rápida</h4>
                    <p class="text-white/80 text-xs">En menos de 24 horas</p>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">💰</div>
                    <h4 class="font-bold text-base mb-0.5">Planes Flexibles</h4>
                    <p class="text-white/80 text-xs">Desde 6 hasta 24 meses</p>
                </div>
                <div>
                    <div class="text-3xl font-bold mb-1">✅</div>
                    <h4 class="font-bold text-base mb-0.5">Aprobación Fácil</h4>
                    <p class="text-white/80 text-xs">Requisitos mínimos</p>
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
                        <h3 class="text-2xl font-bold mb-4 text-orange-500"><img src="{{ asset('images/home/logo_renting.png') }}" alt="Renting365" class="h-8 mx-auto mb-2"></h3>
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
                            <li>+57 310 5367376</li>
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
                <img src="{{ asset('images/home/logo_renting.png') }}" alt="Renting365" class="h-8 mx-auto mb-2">
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
                    <a href="#quiero-mi-moto" class="block w-full bg-white text-orange-600 text-center text-sm font-bold py-2 px-4 rounded-full hover:bg-gray-100 transition shadow-lg">
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
