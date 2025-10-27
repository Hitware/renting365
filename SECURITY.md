# Medidas de Seguridad Implementadas

## Protección contra SQL Injection

### Middlewares
- **PreventSqlInjection**: Detecta y bloquea patrones de SQL injection en todas las solicitudes
- Registra intentos de ataque en logs para auditoría
- Bloquea solicitudes con patrones sospechosos (UNION, SELECT, DROP, etc.)

### Reglas de Validación
- **NoSqlInjection**: Valida campos de formulario contra patrones SQL maliciosos
- **SafeString**: Previene XSS y caracteres peligrosos

### Uso en Formularios
```php
use App\Rules\NoSqlInjection;
use App\Rules\SafeString;

$request->validate([
    'name' => ['required', new NoSqlInjection, new SafeString],
    'email' => ['required', 'email', new NoSqlInjection],
]);
```

## Protección contra Ataques DoS

### Rate Limiting
- **60 solicitudes por minuto** en rutas autenticadas
- Límites configurables por ruta
- Headers de respuesta con información de límites

### Bloqueo de IPs Sospechosas
- **BlockSuspiciousIps**: Bloquea IPs después de 5 intentos fallidos
- Bloqueo temporal de 1 hora
- Registro de actividad sospechosa

### Uso
```php
Route::middleware(['throttle:30,1'])->group(function () {
    // Rutas con límite de 30 req/min
});
```

## Sanitización de Entrada

### SanitizeInput Middleware
- Limpia automáticamente todos los inputs
- Remueve null bytes, tags HTML peligrosos
- Escapa caracteres especiales
- Excepciones para campos de contraseña

## Headers de Seguridad

### SecurityHeaders Middleware
Agrega headers HTTP de seguridad:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `Strict-Transport-Security` (HSTS)
- `Content-Security-Policy` (CSP)
- `Referrer-Policy`
- `Permissions-Policy`

## Protección CSRF

Laravel incluye protección CSRF automática:
- Token CSRF en todos los formularios
- Validación automática en rutas POST/PUT/DELETE
- Middleware `VerifyCsrfToken` activo

## Encriptación de URLs

### Hashids
- IDs encriptados en URLs para Client, User, LeasingContract
- Previene enumeración de recursos
- Trait `HasHashedRouteKey` implementado

## Configuración

### Variables de Entorno (.env)
```env
SQL_INJECTION_PROTECTION=true
LOG_SQL_INJECTION_ATTEMPTS=true
RATE_LIMITING_ENABLED=true
RATE_LIMIT_MAX_ATTEMPTS=60
IP_BLOCKING_ENABLED=true
IP_BLOCK_MAX_ATTEMPTS=5
IP_BLOCK_DURATION=3600
INPUT_SANITIZATION_ENABLED=true
SECURITY_HEADERS_ENABLED=true
```

### Archivo de Configuración
`config/security.php` - Configuración centralizada de seguridad

## Logging y Auditoría

### Eventos Registrados
- Intentos de SQL injection
- IPs bloqueadas
- Solicitudes con firma inválida
- Intentos de acceso no autorizado

### Ubicación de Logs
- `storage/logs/laravel.log`
- Nivel CRITICAL para ataques de seguridad
- Nivel WARNING para actividad sospechosa

## Mejores Prácticas

### En Controladores
```php
// CORRECTO - Usar Eloquent ORM
$user = User::where('email', $request->email)->first();

// INCORRECTO - Query raw sin binding
DB::select("SELECT * FROM users WHERE email = '{$email}'");

// CORRECTO - Query raw con binding
DB::select("SELECT * FROM users WHERE email = ?", [$email]);
```

### En Validaciones
```php
// Siempre validar y sanitizar
$validated = $request->validate([
    'name' => ['required', 'string', 'max:255', new SafeString],
    'email' => ['required', 'email', new NoSqlInjection],
]);
```

### En Rutas
```php
// Aplicar rate limiting
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    // Rutas protegidas
});
```

## Mantenimiento

### Revisar Logs Regularmente
```bash
tail -f storage/logs/laravel.log | grep -i "security\|injection\|blocked"
```

### Actualizar Patrones de Detección
Editar `app/Http/Middleware/PreventSqlInjection.php` para agregar nuevos patrones

### Ajustar Límites
Modificar valores en `.env` según necesidades del sistema

## Respuesta a Incidentes

### IP Bloqueada por Error
```php
use Illuminate\Support\Facades\Cache;

// Desbloquear IP manualmente
Cache::forget('blocked_ip:192.168.1.1');
Cache::forget('failed_attempts:192.168.1.1');
```

### Revisar Intentos de Ataque
```bash
grep "SQL Injection\|blocked IP" storage/logs/laravel.log
```

## Recomendaciones Adicionales

1. **HTTPS**: Usar siempre HTTPS en producción
2. **Firewall**: Configurar firewall a nivel de servidor
3. **Backups**: Realizar backups regulares de base de datos
4. **Actualizaciones**: Mantener Laravel y dependencias actualizadas
5. **Auditorías**: Realizar auditorías de seguridad periódicas
6. **Monitoreo**: Implementar monitoreo de logs en tiempo real
7. **WAF**: Considerar Web Application Firewall para producción
