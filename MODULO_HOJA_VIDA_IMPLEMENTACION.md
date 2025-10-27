# Módulo: Hoja de Vida de Persona - Implementación Completa
## Sistema Renting365

---

## 📋 RESUMEN DEL MÓDULO

El módulo **Hoja de Vida de Persona** es el núcleo del sistema Renting365, centralizando toda la información personal, crediticia, laboral y financiera de los clientes que solicitan créditos para adquisición de motocicletas mediante renting.

### Objetivo Principal
Gestionar el ciclo completo de evaluación crediticia de clientes, desde el registro inicial hasta la aprobación o rechazo, integrando múltiples fuentes de información y automatizando decisiones basadas en reglas de negocio.

---

## ✅ FUNCIONALIDADES IMPLEMENTADAS

### 1. **Gestión de Clientes**
- ✅ Listado de clientes con filtros avanzados (búsqueda, estado, score, analista)
- ✅ Estadísticas en tiempo real (total, en revisión, aprobados, rechazados)
- ✅ Ordenamiento dinámico por múltiples campos
- ✅ Paginación optimizada (20 registros por página)
- ✅ Vista detallada con sistema de tabs

### 2. **Formulario Multi-Paso de Registro**
- ✅ **Paso 1**: Datos Personales (documento, nombres, fecha nacimiento, estado civil, educación)
- ✅ **Paso 2**: Información de Contacto (dirección, teléfonos, email)
- ✅ **Paso 3**: Información Laboral (empleador, cargo, salario, antigüedad)
- ✅ **Paso 4**: Información Financiera (ingresos, egresos, capacidad de pago)
- ✅ **Paso 5**: Referencias (personales, familiares, comerciales)
- ✅ **Paso 6**: Consentimientos (Habeas Data, consulta centrales)
- ✅ Indicador visual de progreso
- ✅ Validación por paso
- ✅ Navegación entre pasos

### 3. **Sistema de Documentos**
- ✅ Carga de documentos (PDF, JPG, PNG - máx 5MB)
- ✅ Tipos de documentos requeridos:
  - Cédula (frontal y reverso)
  - Certificado laboral
  - Desprendible de pago
  - Extracto bancario
  - Recibo de servicio público
- ✅ Versionamiento de documentos
- ✅ Estados: pendiente, en revisión, aprobado, rechazado
- ✅ Almacenamiento seguro en disco privado
- ✅ Indicadores visuales de estado

### 4. **Vista Detallada del Cliente (Tabs)**
- ✅ **Tab Personal**: Datos personales y contactos
- ✅ **Tab Laboral**: Información de empleo actual
- ✅ **Tab Financiero**: Ingresos, egresos, ratio de endeudamiento
- ✅ **Tab Referencias**: Lista de referencias con estado de verificación
- ✅ **Tab Créditos**: Historial crediticio y consulta Midatacrédito
- ✅ **Tab Documentos**: Gestión de documentación digital

### 5. **Integración con Midatacrédito**
- ✅ Servicio de consulta a central de riesgo
- ✅ Cálculo de nivel de riesgo (bajo, medio, alto, muy alto)
- ✅ Simulación de API (preparado para integración real)
- ✅ Control de frecuencia de consultas (máx cada 30 días)

### 6. **Sistema de Aprobación Automática**
- ✅ Evaluación de criterios de aprobación:
  - Score crediticio >= 700
  - Sin deudas vencidas
  - Empleo estable (6+ meses)
  - Ratio de endeudamiento <= 50%
  - Documentos aprobados
  - Referencias verificadas
- ✅ Cálculo de score de aprobación (0-100 puntos)
- ✅ Identificación de casos que requieren aprobación gerencial

### 7. **Seguridad Implementada**
- ✅ Almacenamiento de archivos en disco privado (fuera de public/)
- ✅ Validación de tipos de archivo y tamaño
- ✅ Validación de datos de entrada (documentos colombianos, teléfonos, emails)
- ✅ Control de acceso basado en permisos
- ✅ Protección CSRF automática (Livewire)
- ✅ Auditoría de cambios (created_by, updated_by)

### 8. **UI/UX Avanzada**
- ✅ Diseño responsive (mobile-first)
- ✅ Componentes interactivos con Livewire
- ✅ Indicadores visuales de estado (badges de colores)
- ✅ Iconos SVG para mejor experiencia visual
- ✅ Animaciones de carga
- ✅ Mensajes de feedback claros
- ✅ Formularios con validación en tiempo real

---

## 🗄️ ENTIDADES PRINCIPALES

### 1. **clients** (Clientes)
Tabla principal que almacena información básica del cliente.

**Campos principales:**
- `id`, `user_id`, `document_type`, `document_number`
- `first_name`, `middle_name`, `last_name`, `second_last_name`, `full_name`
- `birth_date`, `birth_place`, `gender`, `marital_status`, `education_level`
- `dependents_count`, `status`, `assigned_analyst_id`, `credit_score`
- `approval_date`, `rejection_reason`
- `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`

**Estados posibles:**
- `registro_inicial`
- `documentacion_pendiente`
- `en_revision`
- `verificacion_referencias`
- `consulta_midatacredito`
- `analisis_financiero`
- `en_revision_gerencia`
- `aprobado`
- `rechazado`
- `congelado`

### 2. **client_contacts** (Contactos)
Almacena direcciones, teléfonos y emails del cliente.

**Campos principales:**
- `contact_type` (residencia, trabajo, correspondencia)
- `address`, `neighborhood`, `city`, `department`, `country`
- `phone_landline`, `phone_mobile`, `email`
- `is_primary`, `is_verified`

### 3. **client_employments** (Información Laboral)
Historial de empleos del cliente.

**Campos principales:**
- `is_current`, `employment_type`
- `employer_name`, `employer_nit`, `employer_phone`, `employer_address`
- `position`, `start_date`, `end_date`
- `monthly_salary`, `other_income`, `total_monthly_income`
- `contract_type`

### 4. **client_financials** (Información Financiera)
Registro mensual de ingresos y egresos.

**Campos principales:**
- `month_year`
- `total_income`, `salary_income`, `commission_income`, `other_income`
- `total_expenses`, `rent_expense`, `utilities_expense`, `food_expense`
- `disposable_income`, `debt_to_income_ratio`, `payment_capacity`

### 5. **client_references** (Referencias)
Referencias personales, familiares y comerciales.

**Campos principales:**
- `reference_type` (personal, familiar, comercial)
- `full_name`, `relationship`, `phone`, `email`, `address`
- `years_known`
- `verification_status` (pendiente, en_verificacion, verificada, no_verificada)
- `verification_date`, `verification_notes`, `verified_by`

### 6. **client_credits** (Créditos)
Historial de créditos activos y pagados.

**Campos principales:**
- `credit_source`, `entity_name`, `credit_type`
- `original_amount`, `current_balance`, `monthly_payment`, `payment_day`
- `start_date`, `end_date`
- `status` (activo, pagado, mora, castigado)
- `days_overdue`, `reported_to_credit_bureau`

### 7. **client_documents** (Documentos)
Gestión de documentación digital con versionamiento.

**Campos principales:**
- `document_type` (cedula_frontal, cedula_reverso, certificado_laboral, etc.)
- `file_name`, `file_path`, `file_size`, `mime_type`
- `version`, `upload_date`, `expiry_date`
- `status` (pendiente, en_revision, aprobado, rechazado)
- `reviewed_by`, `review_date`, `review_comments`
- `is_current_version`, `uploaded_by`

### 8. **client_bank_statements** (Estados de Cuenta)
Análisis de extractos bancarios.

**Campos principales:**
- `bank_name`, `account_type`, `account_number_last4`
- `statement_month`, `statement_year`
- `opening_balance`, `closing_balance`, `average_balance`
- `total_deposits`, `total_withdrawals`
- `salary_detected`, `salary_amount`
- `analysis_status`, `analyzed_at`, `analyzed_by`

### 9. **client_bank_transactions** (Transacciones Bancarias)
Detalle de movimientos bancarios.

**Campos principales:**
- `transaction_date`, `description`, `transaction_type`
- `amount`, `balance`
- `is_recurrent`, `category`

### 10. **client_midatacredito** (Consultas Midatacrédito)
Historial de consultas a central de riesgo.

**Campos principales:**
- `query_date`, `query_type`
- `score`, `risk_level`
- `active_credits_count`, `total_debt`, `overdue_debt`
- `worst_status`, `credit_cards_count`
- `last_query_date`, `inquiries_last_6_months`
- `has_legal_proceedings`, `response_json`
- `queried_by`

### 11. **client_status_history** (Historial de Estados)
Auditoría de cambios de estado.

**Campos principales:**
- `previous_status`, `new_status`
- `changed_by`, `change_reason`, `comments`

### 12. **client_notes** (Notas)
Observaciones y seguimiento.

**Campos principales:**
- `note_type` (general, llamada, reunion, seguimiento, alerta)
- `note_content`, `is_important`, `is_private`
- `created_by`

### 13. **client_consents** (Consentimientos)
Registro de autorizaciones Habeas Data.

**Campos principales:**
- `consent_type` (tratamiento_datos, consulta_centrales, uso_comercial)
- `consent_text`, `accepted`, `acceptance_date`
- `acceptance_ip`, `acceptance_user_agent`
- `revoked`, `revocation_date`

---

## 🔄 FLUJO TÉCNICO COMPLETO

### 1. **Registro de Cliente**

```
Usuario accede a /clients/create
    ↓
Se carga ClientForm (Livewire)
    ↓
Paso 1: Validación de datos personales
    - Documento único
    - Edad entre 18-75 años
    - Campos obligatorios
    ↓
Paso 2: Validación de contacto
    - Email único
    - Formato de teléfono colombiano (+57 3XX XXX XXXX)
    ↓
Paso 3: Validación laboral
    - Salario mínimo 1 SMLV ($1,300,000)
    - Fecha de inicio anterior a hoy
    ↓
Paso 4: Validación financiera
    - Ingresos >= egresos
    - Cálculo de ingreso disponible
    ↓
Paso 5: Validación de referencias
    - Mínimo 2 personales + 1 familiar
    - Datos de contacto completos
    ↓
Paso 6: Consentimientos obligatorios
    - Tratamiento de datos (Habeas Data)
    - Consulta a centrales de riesgo
    ↓
Submit del formulario
    ↓
Transacción de base de datos:
    1. Crear registro en clients
    2. Crear contacto principal en client_contacts
    3. Crear empleo actual en client_employments
    4. Crear información financiera en client_financials
    5. Crear referencias en client_references
    6. Registrar consentimientos en client_consents
    ↓
Redirigir a /clients/{id} (vista detallada)
```

### 2. **Carga de Documentos**

```
Usuario en vista detallada del cliente
    ↓
Selecciona tab "Documentos"
    ↓
Se carga DocumentUpload (Livewire)
    ↓
Usuario selecciona tipo de documento
    ↓
Usuario selecciona archivo (PDF, JPG, PNG)
    ↓
Validación:
    - Tipo de archivo permitido
    - Tamaño máximo 5MB
    ↓
Upload del archivo:
    1. Almacenar en storage/app/private/client_documents
    2. Obtener versión actual del documento
    3. Marcar versiones anteriores como no actuales
    4. Crear registro en client_documents
    5. Estado inicial: "pendiente"
    ↓
Emitir evento 'documentUploaded'
    ↓
Actualizar vista (mostrar documento cargado)
```

### 3. **Consulta Midatacrédito**

```
Analista accede a tab "Créditos"
    ↓
Click en "Consultar Midatacrédito"
    ↓
Validación:
    - Verificar que no haya consulta reciente (< 30 días)
    - Verificar permisos del usuario
    ↓
Llamada a MidatacreditoService::queryClient()
    ↓
Simulación de API (o llamada real):
    - Obtener score crediticio
    - Obtener créditos activos
    - Obtener deudas vencidas
    - Calcular nivel de riesgo
    ↓
Guardar resultado en client_midatacredito
    ↓
Actualizar credit_score en clients
    ↓
Mostrar resultados en interfaz
```

### 4. **Evaluación de Aprobación Automática**

```
Sistema evalúa cliente para aprobación
    ↓
ClientApprovalService::canAutoApprove()
    ↓
Verificar criterios:
    ✓ Score crediticio >= 700
    ✓ Sin deudas vencidas (overdue_debt = 0)
    ✓ Empleo estable (>= 6 meses)
    ✓ Ratio endeudamiento <= 50%
    ✓ Documentos aprobados (mínimo 5)
    ✓ Referencias verificadas (mínimo 2)
    ↓
SI todos los criterios se cumplen:
    → Aprobación automática
    → Estado: "aprobado"
    → Generar contrato
    ↓
SI NO cumple criterios:
    → Verificar si requiere aprobación gerencial:
        - Monto > $10M
        - Score < 650
        - Historial con moras
    ↓
    SI requiere gerencia:
        → Estado: "en_revision_gerencia"
    ↓
    SI NO:
        → Aprobación por analista
        → Estado: "en_revision"
```

### 5. **Cálculo de Score de Aprobación**

```
ClientApprovalService::calculateApprovalScore()
    ↓
Puntuación por categorías:

1. Score Crediticio (40 puntos):
   - >= 750: 40 puntos
   - >= 650: 30 puntos
   - >= 550: 20 puntos

2. Empleo Estable (20 puntos):
   - >= 12 meses: 20 puntos
   - >= 6 meses: 15 puntos
   - >= 3 meses: 10 puntos

3. Capacidad Financiera (20 puntos):
   - Ratio <= 35%: 20 puntos
   - Ratio <= 45%: 15 puntos
   - Ratio <= 50%: 10 puntos

4. Documentación (10 puntos):
   - >= 5 docs aprobados: 10 puntos
   - >= 3 docs aprobados: 5 puntos

5. Referencias (10 puntos):
   - >= 2 verificadas: 10 puntos
   - >= 1 verificada: 5 puntos
    ↓
Score Total: 0-100 puntos
    ↓
Interpretación:
    - 80-100: Aprobación automática
    - 60-79: Aprobación con análisis
    - 40-59: Requiere revisión gerencial
    - 0-39: Alto riesgo de rechazo
```

---

## 🏗️ ARQUITECTURA DE COMPONENTES

### Componentes Livewire Implementados

```
app/Livewire/Clients/
├── ClientList.php          → Listado con filtros y paginación
├── ClientForm.php          → Formulario multi-paso de registro
├── ClientView.php          → Vista detallada con tabs
└── DocumentUpload.php      → Carga de documentos
```

### Servicios Implementados

```
app/Services/
├── MidatacreditoService.php      → Integración con central de riesgo
└── ClientApprovalService.php     → Lógica de aprobación automática
```

### Vistas Blade Implementadas

```
resources/views/
├── clients/
│   ├── index.blade.php           → Layout principal del listado
│   ├── create.blade.php          → Layout del formulario
│   └── show.blade.php            → Layout de vista detallada
└── livewire/clients/
    ├── client-list.blade.php     → Tabla interactiva con filtros
    ├── client-form.blade.php     → Formulario multi-paso
    ├── client-view.blade.php     → Tabs de información
    └── document-upload.blade.php → Interfaz de carga de archivos
```

---

## 🔐 SEGURIDAD IMPLEMENTADA

### 1. **Almacenamiento Seguro de Archivos**
```php
// Configuración en config/filesystems.php
'private' => [
    'driver' => 'local',
    'root' => storage_path('app/private'),
    'visibility' => 'private',
]

// Los archivos se almacenan fuera de public/
// Solo accesibles mediante URLs firmadas
```

### 2. **Validaciones de Entrada**
```php
// Documento colombiano
'document_number' => 'required|numeric|digits_between:6,12|unique:clients'

// Teléfono colombiano
'phone_mobile' => ['required', 'regex:/^\+?57\s?3[0-9]{9}$/']

// Edad válida
'birth_date' => 'required|date|before:-18 years|after:-75 years'

// Salario mínimo
'monthly_salary' => 'required|numeric|min:1300000'
```

### 3. **Control de Acceso**
```php
// En rutas (web.php)
Route::resource('clients', ClientController::class)
    ->middleware('can:clients.view');

// En controladores
$this->authorize('clients.view');
$this->authorize('clients.edit');
```

### 4. **Auditoría de Cambios**
```php
// Automático en modelos
protected static function boot()
{
    parent::boot();
    
    static::creating(function ($model) {
        $model->created_by = auth()->id();
    });
    
    static::updating(function ($model) {
        $model->updated_by = auth()->id();
    });
}
```

### 5. **Protección CSRF**
- Automática en todos los componentes Livewire
- Tokens de sesión seguros
- Cookies httpOnly y SameSite

---

## 📊 ESTADÍSTICAS Y MÉTRICAS

### Dashboard de Clientes
- **Total de clientes**: Contador en tiempo real
- **En revisión**: Clientes en estados pendientes
- **Aprobados**: Clientes con estado "aprobado"
- **Rechazados**: Clientes con estado "rechazado"

### Filtros Disponibles
- Búsqueda por documento, nombre
- Filtro por estado
- Filtro por score crediticio (excelente, bueno, regular, malo)
- Filtro por analista asignado

### Ordenamiento
- Por documento
- Por nombre completo
- Por estado
- Por score crediticio
- Por fecha de creación

---

## 🚀 PRÓXIMOS PASOS RECOMENDADOS

### Funcionalidades Pendientes

1. **Revisión de Documentos**
   - Componente DocumentReview para analistas
   - Modal de revisión con vista previa
   - Aprobación/rechazo con comentarios

2. **Verificación de Referencias**
   - Componente ReferenceVerification
   - Registro de llamadas de verificación
   - Estados de verificación

3. **Análisis Financiero Avanzado**
   - Componente FinancialAnalysis
   - Análisis automático de extractos bancarios
   - Detección de ingresos recurrentes
   - Cálculo de capacidad de pago

4. **Integración Real con Midatacrédito**
   - Implementar llamadas reales a API
   - Manejo de errores y reintentos
   - Cache de consultas

5. **Notificaciones**
   - Email al cambiar estado
   - Notificaciones en tiempo real (Pusher/WebSockets)
   - Alertas de documentos vencidos

6. **Reportes y Exportación**
   - Exportar listado a Excel/PDF
   - Reportes de aprobación
   - Dashboards ejecutivos

7. **Mejoras de UI/UX**
   - Autoguardado de formularios
   - Drag & drop para documentos
   - Vista previa de documentos en modal
   - Timeline de historial de estados

---

## 📝 COMANDOS ÚTILES

### Crear directorio privado para documentos
```bash
mkdir -p storage/app/private/client_documents
chmod 755 storage/app/private
```

### Limpiar caché de Livewire
```bash
php artisan livewire:delete-uploaded-files
```

### Ejecutar migraciones
```bash
php artisan migrate
```

### Crear seeders de prueba
```bash
php artisan db:seed --class=ClientPermissionsSeeder
```

---

## 🎯 CONCLUSIÓN

El módulo **Hoja de Vida de Persona** está implementado con las funcionalidades core necesarias para gestionar el ciclo completo de evaluación crediticia de clientes. 

### Logros Principales:
✅ Formulario multi-paso intuitivo y validado
✅ Sistema de documentos con versionamiento
✅ Vista detallada con tabs organizados
✅ Integración con Midatacrédito (simulada)
✅ Sistema de aprobación automática con reglas de negocio
✅ Seguridad avanzada (almacenamiento privado, validaciones, auditoría)
✅ UI/UX moderna y responsive
✅ Componentes Livewire reactivos

### Tecnologías Utilizadas:
- Laravel 10.x
- Livewire 3.0
- Tailwind CSS
- MySQL 8.0
- PHP 8.1+

El sistema está listo para ser extendido con las funcionalidades adicionales mencionadas en "Próximos Pasos".
