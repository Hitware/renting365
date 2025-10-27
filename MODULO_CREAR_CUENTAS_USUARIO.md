# Módulo: Crear Cuentas de Usuario - Renting365

## 📋 Resumen del Módulo

El módulo **Crear Cuentas de Usuario** es el núcleo del sistema de gestión de identidad y acceso de Renting365. Proporciona un sistema completo de registro, autenticación, autorización y auditoría para usuarios con diferentes roles: Administrador, Asesor de Crédito y Cliente.

Este módulo implementa las mejores prácticas de seguridad en desarrollo de aplicaciones web, incluyendo autenticación de dos factores, verificación de correo y teléfono, validación robusta de datos, control de acceso basado en roles y permisos, y auditoría completa de todas las operaciones.

---

## 🎯 Funcionalidades Principales

### 1. Registro de Usuarios Multi-Rol
- **Registro paso a paso** con validación en tiempo real
- **Tres pasos intuitivos**: Cuenta → Datos Personales → Confirmación
- **Validación de unicidad** para email, teléfono y documento
- **Asignación automática de roles** según tipo de usuario
- **Interfaz responsive** y accesible (WCAG 2.1 AA)

### 2. Verificación de Identidad
- **Verificación de correo electrónico** mediante tokens únicos con expiración (24 horas)
- **Verificación de teléfono** mediante códigos OTP de 6 dígitos (10 minutos)
- **Sistema de reenvío** con rate limiting para prevenir abuso
- **Notificaciones automáticas** por email y SMS

### 3. Autenticación de Dos Factores (2FA)
- **Códigos OTP de 6 dígitos** enviados por SMS o email
- **Límite de intentos** (3 intentos máximo) con bloqueo temporal
- **Expiración de códigos** (10 minutos)
- **Limpieza automática** de códigos expirados

### 4. Control de Acceso Basado en Roles (RBAC)
- **3 roles predefinidos**: Admin, Credit Advisor, Client
- **Sistema de permisos granulares** por módulo y acción
- **Middleware de verificación** de roles y permisos
- **Asignación dinámica** de roles con auditoría

### 5. Validaciones Avanzadas
- **Validación de documentos colombianos**: CC, CE, TI, PAS, NIT (con dígito de verificación)
- **Validación de teléfonos colombianos**: Móviles, fijos, formato internacional
- **Contraseñas seguras**: Mínimo 8 caracteres, mayúsculas, minúsculas, números y caracteres especiales
- **Validación en tiempo real** con feedback inmediato

### 6. Auditoría y Trazabilidad
- **Registro automático** de todas las operaciones críticas
- **Observers de Eloquent** para cambios en modelos
- **Event Listeners** para eventos de autenticación
- **Almacenamiento de metadata**: IP, User Agent, timestamp
- **Datos estructurados en JSON** para búsqueda y análisis

### 7. Seguridad Avanzada
- **Cifrado de contraseñas** con bcrypt (factor 12)
- **Protección CSRF** en todos los formularios
- **Rate limiting** en endpoints sensibles
- **Sanitización de entradas** para prevenir XSS
- **Soft deletes** para preservar integridad de datos
- **Validación de sesiones** y detección de cuentas inactivas

---

## 🗄️ Entidades Principales

### 1. **Users**
Almacena la información de autenticación y estado de los usuarios.

**Atributos clave:**
- `email` (unique, verified)
- `password` (hashed)
- `phone` (unique, verified)
- `is_active` (boolean)
- `last_login_at` (timestamp)

**Relaciones:**
- `hasOne(UserProfile)` - Perfil del usuario
- `belongsToMany(Role)` - Roles asignados
- `hasMany(VerificationToken)` - Tokens de verificación
- `hasMany(TwoFactorCode)` - Códigos 2FA
- `hasMany(ActivityLog)` - Logs de actividad

### 2. **UserProfiles**
Información detallada del perfil del usuario.

**Atributos clave:**
- `first_name`, `last_name`
- `document_type`, `document_number` (unique)
- `address`, `city`, `state`, `postal_code`
- `birth_date`

**Relaciones:**
- `belongsTo(User)` - Usuario propietario

### 3. **Roles**
Define los roles disponibles en el sistema.

**Atributos clave:**
- `name`, `slug` (unique)
- `description`

**Relaciones:**
- `belongsToMany(User)` - Usuarios con este rol
- `belongsToMany(Permission)` - Permisos asignados

### 4. **Permissions**
Permisos granulares por módulo.

**Atributos clave:**
- `name`, `slug` (unique)
- `module` (agrupación)
- `description`

**Relaciones:**
- `belongsToMany(Role)` - Roles que tienen este permiso

### 5. **VerificationTokens**
Tokens para verificación de email y teléfono.

**Atributos clave:**
- `token` (unique)
- `type` (email/phone)
- `expires_at`
- `verified_at`

### 6. **TwoFactorCodes**
Códigos OTP para autenticación de dos factores.

**Atributos clave:**
- `code` (6 dígitos)
- `type` (sms/email)
- `expires_at`
- `attempts` (contador)

### 7. **ActivityLogs**
Registro de todas las actividades del sistema.

**Atributos clave:**
- `action` (tipo de acción)
- `module` (módulo del sistema)
- `ip_address`, `user_agent`
- `data` (JSON con metadata)

---

## 🔄 Flujo Técnico Completo

### **Flujo de Registro**

```
┌─────────────────────────────────────────────────────────────────┐
│                    INICIO DE REGISTRO                           │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  PASO 1: Información de Cuenta                                  │
│  - Email (validación de unicidad en tiempo real)                │
│  - Contraseña (validación de seguridad)                         │
│  - Teléfono (opcional, validación de formato)                   │
│  ✓ Validación frontend y backend                                │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  PASO 2: Datos Personales                                       │
│  - Nombres y Apellidos                                          │
│  - Tipo y número de documento (validación colombiana)           │
│  - Dirección, ciudad, departamento                              │
│  - Fecha de nacimiento                                          │
│  ✓ Validación de documento único                                │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  PASO 3: Confirmación                                           │
│  - Resumen de información ingresada                             │
│  - Aceptación de términos y condiciones                         │
│  ✓ Validación final                                             │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  PROCESAMIENTO (UserRegistrationService)                        │
│  1. Transacción de base de datos                                │
│  2. Hash de contraseña (bcrypt)                                 │
│  3. Creación de User                                            │
│  4. Creación de UserProfile                                     │
│  5. Asignación de Role                                          │
│  6. Generación de token de verificación de email (24h)          │
│  7. Generación de token de verificación de teléfono (30min)     │
│  8. Envío de notificaciones                                     │
│  9. Registro en ActivityLog                                     │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  VERIFICACIÓN DE EMAIL                                          │
│  - Usuario recibe email con enlace                              │
│  - Click en enlace → Verificación de token                      │
│  - Marca email_verified_at                                      │
│  - Registro en ActivityLog                                      │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  VERIFICACIÓN DE TELÉFONO (opcional)                            │
│  - Usuario recibe SMS con código de 6 dígitos                   │
│  - Ingreso de código → Validación                               │
│  - Máximo 3 intentos, expiración 10 minutos                     │
│  - Marca phone_verified_at                                      │
│  - Registro en ActivityLog                                      │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│               CUENTA ACTIVA Y LISTA PARA USAR                   │
└─────────────────────────────────────────────────────────────────┘
```

### **Flujo de Autenticación con 2FA**

```
┌─────────────────────────────────────────────────────────────────┐
│  INICIO DE SESIÓN                                               │
│  - Email y contraseña                                           │
│  - Validación de credenciales                                   │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  VERIFICACIÓN DE CUENTA                                         │
│  - ¿Usuario activo? (is_active)                                 │
│  - ¿Email verificado? (email_verified_at)                       │
│  - ¿Contraseña correcta?                                        │
│  ✓ Rate limiting: máximo 5 intentos en 5 minutos               │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  GENERACIÓN DE CÓDIGO 2FA                                       │
│  - Código OTP de 6 dígitos                                      │
│  - Envío por SMS o email                                        │
│  - Expiración: 10 minutos                                       │
│  - Almacenamiento en TwoFactorCodes                             │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  VALIDACIÓN DE CÓDIGO 2FA                                       │
│  - Usuario ingresa código                                       │
│  - Verificación de validez y expiración                         │
│  - Incremento de intentos (máx 3)                               │
│  - Marca código como verificado                                 │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  SESIÓN INICIADA                                                │
│  - Actualización de last_login_at                               │
│  - Carga de roles y permisos (cache)                            │
│  - Registro en ActivityLog                                      │
│  - Redirección a dashboard                                      │
└─────────────────────────────────────────────────────────────────┘
```

### **Flujo de Control de Acceso**

```
┌─────────────────────────────────────────────────────────────────┐
│  SOLICITUD DE RECURSO PROTEGIDO                                 │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  MIDDLEWARE: CheckRole / CheckPermission                        │
│  1. ¿Usuario autenticado?                                       │
│  2. ¿Usuario activo?                                            │
│  3. ¿Email verificado? (si aplica)                              │
│  4. ¿Teléfono verificado? (si aplica)                           │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  VERIFICACIÓN DE ROLES                                          │
│  - Consulta roles del usuario                                   │
│  - Compara con roles requeridos                                 │
│  - Si no tiene rol → 403 Forbidden                              │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  VERIFICACIÓN DE PERMISOS                                       │
│  - Consulta permisos de los roles del usuario                   │
│  - Compara con permiso requerido                                │
│  - Si no tiene permiso → 403 Forbidden                          │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  ACCESO CONCEDIDO                                               │
│  - Ejecución de la acción                                       │
│  - Registro en ActivityLog (si aplica)                          │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔒 Seguridad Implementada

### **1. Autenticación y Autorización**
- ✅ Contraseñas hasheadas con bcrypt (factor 12+)
- ✅ Autenticación de dos factores (2FA)
- ✅ Verificación de email y teléfono
- ✅ Control de acceso basado en roles (RBAC)
- ✅ Permisos granulares por módulo

### **2. Protección contra Ataques**
- ✅ **CSRF Protection**: Tokens en todos los formularios
- ✅ **Rate Limiting**: Límites en login, registro, 2FA
- ✅ **XSS Prevention**: Sanitización de entradas
- ✅ **SQL Injection**: Uso de Eloquent ORM y prepared statements
- ✅ **Brute Force**: Bloqueo temporal después de intentos fallidos

### **3. Gestión de Sesiones**
- ✅ Sesiones seguras con HttpOnly y Secure flags
- ✅ Regeneración de sesión después de login
- ✅ Cierre automático de sesiones inactivas
- ✅ Detección de múltiples sesiones

### **4. Validación y Sanitización**
- ✅ Validación en frontend (Livewire real-time)
- ✅ Validación en backend (Form Requests)
- ✅ Reglas de validación personalizadas
- ✅ Sanitización de datos antes de almacenar

### **5. Auditoría y Monitoreo**
- ✅ Registro completo de actividades
- ✅ Observers automáticos en modelos críticos
- ✅ Event Listeners para eventos de auth
- ✅ Metadata de contexto (IP, User Agent)
- ✅ Middleware de logging para mutaciones

---

## 📁 Estructura de Archivos

```
app/
├── Http/
│   ├── Livewire/
│   │   └── Auth/
│   │       ├── Register.php                    # Componente de registro
│   │       ├── VerifyEmail.php                 # Verificación de email
│   │       ├── VerifyPhone.php                 # Verificación de teléfono
│   │       └── TwoFactorChallenge.php          # Desafío 2FA
│   └── Middleware/
│       ├── CheckRole.php                       # Verificación de roles
│       ├── CheckPermission.php                 # Verificación de permisos
│       ├── EnsureEmailIsVerified.php           # Requiere email verificado
│       ├── EnsurePhoneIsVerified.php           # Requiere teléfono verificado
│       └── LogActivity.php                     # Logging de actividades
├── Models/
│   ├── User.php                                # Modelo de usuario (extendido)
│   ├── UserProfile.php                         # Perfil de usuario
│   ├── Role.php                                # Roles del sistema
│   ├── Permission.php                          # Permisos
│   ├── VerificationToken.php                   # Tokens de verificación
│   ├── TwoFactorCode.php                       # Códigos 2FA
│   └── ActivityLog.php                         # Logs de actividad
├── Services/
│   ├── UserRegistrationService.php             # Lógica de registro
│   └── TwoFactorAuthService.php                # Lógica de 2FA
├── Rules/
│   ├── ValidColombianDocument.php              # Validación de documentos
│   ├── ValidColombianPhone.php                 # Validación de teléfonos
│   └── StrongPassword.php                      # Validación de contraseñas
├── Observers/
│   ├── UserObserver.php                        # Observer de User
│   └── UserProfileObserver.php                 # Observer de UserProfile
└── Listeners/
    ├── LogSuccessfulLogin.php                  # Listener de login exitoso
    ├── LogFailedLogin.php                      # Listener de login fallido
    └── LogLogout.php                           # Listener de logout

database/
├── migrations/
│   ├── 2024_01_01_000001_create_roles_table.php
│   ├── 2024_01_01_000002_create_permissions_table.php
│   ├── 2024_01_01_000003_add_user_fields_to_users_table.php
│   ├── 2024_01_01_000004_create_user_profiles_table.php
│   ├── 2024_01_01_000005_create_role_user_table.php
│   ├── 2024_01_01_000006_create_role_permission_table.php
│   ├── 2024_01_01_000007_create_verification_tokens_table.php
│   ├── 2024_01_01_000008_create_two_factor_codes_table.php
│   └── 2024_01_01_000009_create_activity_logs_table.php
└── seeders/
    └── RolesAndPermissionsSeeder.php           # Seeder de roles y permisos

resources/
└── views/
    └── livewire/
        └── auth/
            └── register.blade.php              # Vista de registro (UI/UX)
```

---

## 🚀 Instalación y Configuración

### **1. Ejecutar Migraciones**

```bash
php artisan migrate
```

### **2. Ejecutar Seeders**

```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

### **3. Configurar Middleware (app/Http/Kernel.php)**

```php
protected $middlewareAliases = [
    // ... otros middleware
    'role' => \App\Http\Middleware\CheckRole::class,
    'permission' => \App\Http\Middleware\CheckPermission::class,
    'verified.email' => \App\Http\Middleware\EnsureEmailIsVerified::class,
    'verified.phone' => \App\Http\Middleware\EnsurePhoneIsVerified::class,
    'log.activity' => \App\Http\Middleware\LogActivity::class,
];
```

### **4. Configurar Rutas (routes/web.php)**

```php
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\VerifyEmail;
use App\Http\Livewire\Auth\VerifyPhone;
use App\Http\Livewire\Auth\TwoFactorChallenge;

// Rutas públicas
Route::get('/register', Register::class)->name('register');
Route::get('/verify-email', VerifyEmail::class)->name('verification.notice');
Route::get('/verify-email/{token}', VerifyEmail::class)->name('verification.verify');
Route::get('/two-factor-challenge', TwoFactorChallenge::class)->name('two-factor.challenge');

// Rutas protegidas
Route::middleware(['auth', 'verified.email'])->group(function () {
    Route::get('/verify-phone', VerifyPhone::class)->name('verification.phone');

    // Dashboard con verificación de rol
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,credit_advisor,client')->name('dashboard');

    // Rutas de administración
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Gestión de usuarios
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });

    // Rutas de asesor de crédito
    Route::middleware('role:admin,credit_advisor')->prefix('credits')->group(function () {
        // Gestión de créditos
    });
});
```

### **5. Configurar Notificaciones**

Crear notificaciones para envío de emails y SMS:

```bash
php artisan make:notification EmailVerificationNotification
php artisan make:notification PhoneVerificationNotification
php artisan make:notification TwoFactorCodeNotification
```

### **6. Configurar Queue para Notificaciones (opcional)**

```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

---

## 🎨 Diseño UI/UX

### **Características de la Interfaz**

1. **Design System Moderno**
   - Colores: Degradados azul (#3B82F6) a índigo (#6366F1)
   - Tipografía: Sans-serif moderna, jerarquía clara
   - Espaciado consistente: Tailwind CSS spacing scale

2. **Componentes Interactivos**
   - Barra de progreso visual con 3 pasos
   - Iconos contextuales en cada campo
   - Validación en tiempo real con feedback visual
   - Animaciones suaves (fadeIn, transitions)

3. **Accesibilidad**
   - Labels descriptivos en todos los campos
   - Mensajes de error claros y contextuales
   - Navegación por teclado
   - Contraste WCAG 2.1 AA compliant

4. **Responsive Design**
   - Mobile-first approach
   - Grid adaptativo (1 columna móvil, 2-3 columnas desktop)
   - Touch-friendly (botones grandes, espaciado adecuado)

5. **Estados de Carga**
   - Spinners durante procesamiento
   - Deshabilitación de botones durante submit
   - Mensajes de confirmación

---

## 📊 Matriz de Permisos por Rol

| Módulo | Permiso | Admin | Credit Advisor | Client |
|--------|---------|-------|----------------|--------|
| **Users** | Ver usuarios | ✅ | ✅ | ❌ |
| | Ver perfil propio | ✅ | ✅ | ✅ |
| | Crear usuarios | ✅ | ❌ | ❌ |
| | Editar usuarios | ✅ | ❌ | ❌ |
| | Editar perfil propio | ✅ | ✅ | ✅ |
| | Eliminar usuarios | ✅ | ❌ | ❌ |
| | Asignar roles | ✅ | ❌ | ❌ |
| **Roles** | Ver roles | ✅ | ❌ | ❌ |
| | Crear roles | ✅ | ❌ | ❌ |
| | Editar roles | ✅ | ❌ | ❌ |
| | Asignar permisos | ✅ | ❌ | ❌ |
| **Logs** | Ver logs | ✅ | ✅ | ❌ |
| | Exportar logs | ✅ | ❌ | ❌ |
| **Credits** | Ver solicitudes | ✅ | ✅ | ❌ |
| | Ver mis solicitudes | ✅ | ✅ | ✅ |
| | Crear solicitudes | ✅ | ✅ | ✅ |
| | Aprobar solicitudes | ✅ | ✅ | ❌ |

---

## 🧪 Testing y Validación

### **Tests Recomendados**

```bash
# Tests de registro
php artisan test --filter UserRegistrationTest

# Tests de autenticación
php artisan test --filter AuthenticationTest

# Tests de 2FA
php artisan test --filter TwoFactorAuthTest

# Tests de roles y permisos
php artisan test --filter RolePermissionTest

# Tests de validación
php artisan test --filter ValidationTest
```

### **Casos de Prueba Críticos**

1. **Registro**
   - Registro exitoso con datos válidos
   - Validación de email duplicado
   - Validación de documento duplicado
   - Validación de contraseña débil
   - Validación de documentos colombianos

2. **Autenticación**
   - Login exitoso
   - Login con credenciales incorrectas
   - Rate limiting en intentos fallidos
   - 2FA exitoso
   - 2FA con código expirado
   - 2FA con máximo de intentos excedidos

3. **Control de Acceso**
   - Acceso con rol correcto
   - Acceso denegado sin rol
   - Acceso denegado sin permiso
   - Acceso denegado con cuenta inactiva

4. **Auditoría**
   - Registro de login exitoso
   - Registro de login fallido
   - Registro de cambios en perfil
   - Registro de asignación de roles

---

## 📈 Métricas y Monitoreo

### **KPIs del Módulo**

1. **Registro**
   - Tasa de conversión por paso
   - Tiempo promedio de registro
   - Tasa de abandono por paso
   - Tasa de verificación de email/teléfono

2. **Seguridad**
   - Intentos de login fallidos
   - Intentos de 2FA fallidos
   - Cuentas bloqueadas por rate limiting
   - Accesos denegados por falta de permisos

3. **Uso**
   - Usuarios activos por rol
   - Logins diarios/semanales/mensuales
   - Distribución de roles
   - Acciones más frecuentes por rol

---

## 🔧 Mantenimiento

### **Tareas Periódicas**

```bash
# Limpiar tokens expirados (ejecutar diariamente)
php artisan schedule:run

# En app/Console/Kernel.php:
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        \App\Services\TwoFactorAuthService::cleanupExpiredCodes();
    })->daily();

    $schedule->call(function () {
        \App\Models\VerificationToken::where('expires_at', '<', now())->delete();
    })->daily();
}
```

### **Backups Recomendados**

- Base de datos: Diario
- Logs de actividad: Semanal
- Configuración de roles y permisos: Mensual

---

## 📞 Soporte y Contacto

Para soporte técnico o consultas sobre este módulo:
- **Email**: soporte@renting365.co
- **Documentación**: https://docs.renting365.co
- **GitHub**: https://github.com/renting365/system

---

**Desarrollado con ❤️ para Renting365**
*Versión: 1.0.0 | Fecha: 2024*
