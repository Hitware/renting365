<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Renting365') }} - Facilita tu vida</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="fixed w-full top-0 z-50 bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="text-2xl font-bold text-orange-600">RENTING365</a>
                <div class="hidden md:flex items-center space-x-6 text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +57 314 5144067
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Cartagena, Colombia
                    </div>
                </div>
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="#inicio" class="text-gray-700 hover:text-orange-600 transition">Inicio</a>
                    <a href="#planes" class="text-gray-700 hover:text-orange-600 transition">Planes</a>
                    <a href="#beneficios" class="text-gray-700 hover:text-orange-600 transition">Beneficios</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-orange-600 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600 transition">Iniciar Sesión</a>
                        @endauth
                    @endif
                    <a href="#contacto" class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-full transition">PAGAR CUOTA</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section id="inicio" class="pt-32 pb-20 bg-gradient-to-br from-orange-50 to-white">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight text-gray-900">
                        Renting365<br>
                        <span class="text-orange-600">Facilita tu vida</span>
                    </h1>
                    <p class="text-xl text-gray-700 leading-relaxed">
                        Genera ingresos extras y mejora tu movilidad con nuestro servicio de renting de motos. Sin cuota inicial, con mantenimiento incluido y seguro completo.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#planes" class="px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-full text-center transition shadow-lg">Ver Planes Disponibles</a>
                        <a href="#contacto" class="px-8 py-4 border-2 border-orange-600 text-orange-600 hover:bg-orange-50 font-semibold rounded-full text-center transition">Hablar con un Asesor</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="w-full h-96 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-2xl flex items-center justify-center text-white text-2xl font-bold">
                        🏍️ Moto Renting365
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Planes -->
    <section id="planes" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Nuestros Planes</h2>
                <p class="text-xl text-gray-600">Elige el plan que mejor se adapte a tus necesidades</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Plan Delivery -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-transparent hover:border-orange-500 transition">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-orange-600 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Plan Delivery</h3>
                        <div class="text-4xl font-bold my-4 text-orange-600">$350.000<span class="text-base text-gray-600">/mes</span></div>
                        <ul class="text-left space-y-3 mb-8">
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Ideal para delivery y mensajería</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Sin cuota inicial</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Mantenimiento incluido</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>SOAT y seguros incluidos</span></li>
                        </ul>
                        <a href="#contacto" class="block w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-full text-center transition">Solicitar Plan</a>
                    </div>
                </div>

                <!-- Plan Universitario -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-orange-500 transform md:scale-105 relative">
                    <div class="absolute top-0 right-0 bg-orange-600 text-white px-4 py-1 rounded-bl-lg text-sm font-semibold">Más Popular</div>
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-orange-600 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Plan Universitario</h3>
                        <div class="text-4xl font-bold my-4 text-orange-600">$280.000<span class="text-base text-gray-600">/mes</span></div>
                        <ul class="text-left space-y-3 mb-8">
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Especial para estudiantes</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Sin cuota inicial</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Mantenimiento incluido</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>SOAT y seguros incluidos</span></li>
                        </ul>
                        <a href="#contacto" class="block w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-full text-center transition">Solicitar Plan</a>
                    </div>
                </div>

                <!-- Plan Emprendedor -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-transparent hover:border-orange-500 transition">
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-orange-600 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Plan Emprendedor</h3>
                        <div class="text-4xl font-bold my-4 text-orange-600">$400.000<span class="text-base text-gray-600">/mes</span></div>
                        <ul class="text-left space-y-3 mb-8">
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Para negocios y emprendimientos</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Sin cuota inicial</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>Mantenimiento incluido</span></li>
                            <li class="flex items-start"><svg class="w-6 h-6 mr-2 text-orange-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>SOAT y seguros incluidos</span></li>
                        </ul>
                        <a href="#contacto" class="block w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-full text-center transition">Solicitar Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Beneficios -->
    <section id="beneficios" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">Beneficios Incluidos</h2>
                <p class="text-xl text-gray-600">Todo lo que necesitas en un solo paquete</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-lg text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-orange-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">SOAT Incluido</h3>
                    <p class="text-gray-600">Seguro obligatorio cubierto durante todo el periodo de renting</p>
                </div>
                <div class="bg-white rounded-xl p-8 shadow-lg text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-orange-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Mantenimiento</h3>
                    <p class="text-gray-600">Mantenimiento preventivo y correctivo sin costo adicional</p>
                </div>
                <div class="bg-white rounded-xl p-8 shadow-lg text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-orange-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-900">Fondo de Siniestralidad</h3>
                    <p class="text-gray-600">Protección ante imprevistos y siniestros durante el contrato</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="contacto" class="py-20 bg-orange-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">¿Listo para comenzar?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Únete a cientos de personas que ya están generando ingresos y mejorando su movilidad con Renting365</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#planes" class="px-8 py-4 bg-white text-orange-600 hover:bg-gray-100 rounded-full font-semibold text-center transition">Ver Todos los Planes</a>
                <a href="https://wa.me/573145144067" class="px-8 py-4 border-2 border-white hover:bg-white/10 rounded-full font-semibold text-center transition">Contactar por WhatsApp</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-orange-500">RENTING365</h3>
                    <p class="text-gray-400">Facilita tu vida con nuestro servicio de renting de motos</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#inicio" class="hover:text-white transition">Inicio</a></li>
                        <li><a href="#planes" class="hover:text-white transition">Planes</a></li>
                        <li><a href="#beneficios" class="hover:text-white transition">Beneficios</a></li>
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
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Renting365. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
