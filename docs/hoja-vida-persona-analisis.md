# Módulo: Hoja de Vida de Persona - Renting365
## Análisis Técnico y Arquitectura

---

## 📋 RESUMEN EJECUTIVO

El módulo **Hoja de Vida de Persona** es el núcleo del sistema Renting365, centralizando toda la información personal, financiera, crediticia y laboral de los clientes que solicitan créditos para adquisición de motocicletas mediante renting.

Este módulo actúa como **repositorio central de información del cliente** e integra datos de múltiples fuentes:
- Datos personales y de contacto
- Información laboral y financiera
- Historial crediticio
- Referencias personales y comerciales
- Documentación digital verificada
- Estados de cuenta bancarios
- Integración con Midatacrédito

---

## 🎯 REQUISITOS FUNCIONALES

### RF-001: Gestión de Datos Personales
- Captura y actualización de información personal del cliente
- Validación de documentos de identidad (CC, CE, TI, PP)
- Registro de múltiples direcciones (residencia, trabajo, correspondencia)
- Gestión de contactos (teléfono, email, redes sociales)
- Datos demográficos (fecha nacimiento, estado civil, género, nivel educativo)

### RF-002: Información Laboral
- Registro de empleo actual y empleos anteriores
- Tipo de contratación (indefinido, temporal, prestación de servicios, independiente)
- Datos del empleador (nombre, NIT, teléfono, dirección)
- Cargo, antigüedad y estabilidad laboral
- Documentación laboral (certificados, contratos)

### RF-003: Información Financiera
- Registro de ingresos mensuales (salario, comisiones, otros ingresos)
- Declaración de egresos mensuales (arriendo, servicios, alimentación, transporte, educación, otros)
- Cálculo automático de capacidad de pago
- Validación de relación ingreso/egreso
- Soporte documental (certificados laborales, extractos bancarios)

### RF-004: Referencias
- Referencias personales (mínimo 2)
- Referencias familiares (mínimo 1)
- Referencias comerciales
- Validación de datos de contacto de referencias
- Estado de verificación de referencias

### RF-005: Historial Crediticio
- Consulta automática a Midatacrédito
- Registro de créditos activos (entidad, monto, cuota, saldo)
- Historial de créditos pagados
- Score crediticio
- Comportamiento de pago
- Alertas de mora o reportes negativos

### RF-006: Documentación Digital
- Carga de documentos en formato PDF, JPG, PNG
- Tipos de documentos:
  - Cédula de ciudadanía (anverso y reverso)
  - Certificado laboral (máx 30 días antigüedad)
  - Comprobantes de ingresos (desprendibles de pago)
  - Extractos bancarios (últimos 3 meses)
  - Servicios públicos (recibo de luz/agua máx 2 meses)
  - Referencias firmadas
  - Contratos de renting
- Versionamiento de documentos
- Estados: pendiente, en revisión, aprobado, rechazado
- Comentarios del evaluador

### RF-007: Estados de Cuenta
- Carga de extractos bancarios
- Análisis automático de movimientos
- Detección de ingresos recurrentes
- Identificación de egresos fijos
- Cálculo de promedio de saldo
- Alertas de sobregiros o movimientos irregulares

### RF-008: Flujo de Aprobación
- Estados del cliente:
  - Registro inicial
  - Documentación en revisión
  - Verificación de referencias
  - Consulta Midatacrédito
  - Análisis financiero
  - Aprobado
  - Rechazado
  - Congelado/Suspendido
- Asignación de analista de crédito
- Comentarios y observaciones por etapa
- Historial de cambios de estado
- Notificaciones automáticas

### RF-009: Búsqueda y Filtros
- Búsqueda por documento, nombre, email, teléfono
- Filtros por estado, fecha de registro, analista asignado, score crediticio
- Ordenamiento por múltiples campos
- Exportación de listados a Excel/PDF

### RF-010: Integración con Otros Módulos
- **Midatacrédito**: Consulta automática de historial crediticio
- **Referencias**: Validación de referencias personales
- **Estados de cuenta**: Análisis financiero automático
- **Solicitudes de crédito**: Vinculación con solicitudes
- **Contratos**: Generación de contratos aprobados

---

## ❌ REQUISITOS NO FUNCIONALES

### RNF-001: Seguridad
- **Cifrado de datos sensibles**: AES-256 para números de cuenta, ingresos, información financiera
- **Control de acceso basado en roles** (RBAC)
- **Auditoría completa** de accesos y modificaciones
- **Protección CSRF** en todos los formularios
- **Validación y sanitización** de todas las entradas
- **Almacenamiento seguro de archivos** fuera de public/
- **URLs firmadas** para descarga de documentos
- **Sesiones seguras** con cookies httpOnly y SameSite

### RNF-002: Rendimiento
- Carga de listado de clientes en < 500ms
- Componentes Livewire con lazy loading
- Paginación de 20 registros por defecto
- Cache de consultas frecuentes (15 minutos)
- Optimización de consultas N+1 con eager loading
- Compresión de imágenes al subir documentos

### RNF-003: Usabilidad
- Interfaz intuitiva y responsive (mobile-first)
- Formularios multi-paso con indicadores de progreso
- Validación en tiempo real (Livewire)
- Mensajes de error claros y en español
- Ayudas contextuales (tooltips)
- Autoguardado de formularios
- Navegación clara con breadcrumbs

### RNF-004: Disponibilidad
- Disponibilidad del 99.5%
- Backups automáticos diarios de BD y archivos
- Recuperación ante desastres (RPO: 24h, RTO: 4h)

### RNF-005: Escalabilidad
- Soportar hasta 10,000 clientes activos
- Crecimiento del 20% anual
- Arquitectura modular para agregar nuevas funcionalidades

### RNF-006: Cumplimiento Legal
- **Ley de Habeas Data** (Colombia): Consentimiento explícito para tratamiento de datos personales
- **GDPR** consideraciones para datos sensibles
- Política de retención de datos (7 años para documentos financieros)
- Derecho al olvido y portabilidad de datos

---

## 👥 ROLES DE USUARIO

### 1. **Cliente** (Perfil limitado)
- Ver su propia hoja de vida
- Actualizar datos personales básicos
- Cargar documentos solicitados
- Ver estado de su solicitud

### 2. **Asesor Comercial**
- Crear nuevas hojas de vida de clientes
- Editar información personal y laboral
- Cargar documentación inicial
- Solicitar documentos faltantes
- Ver estado general de clientes asignados

### 3. **Analista de Crédito**
- Ver todas las hojas de vida
- Revisar y validar documentación
- Realizar consultas a Midatacrédito
- Analizar capacidad financiera
- Aprobar/rechazar solicitudes
- Dejar comentarios y observaciones
- Solicitar documentos adicionales

### 4. **Gerente de Crédito**
- Todas las funciones del Analista
- Aprobar créditos sobre cierto monto
- Ver dashboards de aprobación
- Generar reportes ejecutivos
- Configurar parámetros de evaluación

### 5. **Administrador del Sistema**
- Gestión completa de módulo
- Configuración de validaciones
- Gestión de permisos
- Acceso a logs de auditoría
- Exportación masiva de datos

---

## 🗄️ ENTIDADES PRINCIPALES Y RELACIONES

### 1. **clients** (Clientes)
```sql
- id (PK)
- user_id (FK a users - opcional si cliente no tiene login)
- document_type (CC, CE, TI, PP)
- document_number (único, indexado)
- first_name
- middle_name (nullable)
- last_name
- second_last_name (nullable)
- full_name (generado)
- birth_date
- birth_place
- gender (M, F, Otro, Prefiero no decir)
- marital_status (soltero, casado, unión libre, divorciado, viudo)
- education_level (primaria, secundaria, técnico, tecnólogo, profesional, posgrado)
- dependents_count (número de personas a cargo)
- status (registro_inicial, en_revision, aprobado, rechazado, congelado)
- assigned_analyst_id (FK a users)
- credit_score (calculado)
- approval_date
- rejection_reason
- created_by (FK a users)
- updated_by (FK a users)
- created_at
- updated_at
- deleted_at (soft delete)
```

### 2. **client_contacts** (Contactos)
```sql
- id (PK)
- client_id (FK)
- contact_type (residencia, trabajo, correspondencia, otro)
- address
- neighborhood
- city
- department
- country (default: Colombia)
- postal_code
- phone_landline
- phone_mobile
- email
- is_primary (boolean)
- is_verified (boolean)
- verification_date
- created_at
- updated_at
```

### 3. **client_employments** (Información Laboral)
```sql
- id (PK)
- client_id (FK)
- is_current (boolean)
- employment_type (empleado_indefinido, empleado_temporal, prestacion_servicios, independiente, pensionado)
- employer_name
- employer_nit
- employer_phone
- employer_address
- employer_city
- position
- start_date
- end_date (nullable si is_current)
- monthly_salary (cifrado)
- other_income (cifrado)
- total_monthly_income (cifrado)
- contract_type (indefinido, fijo, obra_labor, prestacion_servicios)
- created_at
- updated_at
```

### 4. **client_financials** (Información Financiera)
```sql
- id (PK)
- client_id (FK)
- month_year (formato YYYY-MM)
- total_income (cifrado)
- salary_income (cifrado)
- commission_income (cifrado)
- rental_income (cifrado)
- other_income (cifrado)
- total_expenses (cifrado)
- rent_expense (cifrado)
- utilities_expense (cifrado)
- food_expense (cifrado)
- transport_expense (cifrado)
- education_expense (cifrado)
- credit_payments_expense (cifrado)
- other_expenses (cifrado)
- disposable_income (calculado: total_income - total_expenses)
- debt_to_income_ratio (calculado)
- payment_capacity (calculado)
- created_at
- updated_at
```

### 5. **client_references** (Referencias)
```sql
- id (PK)
- client_id (FK)
- reference_type (personal, familiar, comercial)
- full_name
- relationship (amigo, familiar, compañero_trabajo, proveedor, etc.)
- phone
- email
- address
- city
- years_known
- verification_status (pendiente, en_verificacion, verificada, no_verificada)
- verification_date
- verification_notes
- verified_by (FK a users)
- created_at
- updated_at
```

### 6. **client_credits** (Créditos Activos e Históricos)
```sql
- id (PK)
- client_id (FK)
- credit_source (renting365, banco, cooperativa, tarjeta_credito, otro)
- entity_name
- credit_type (consumo, vivienda, vehiculo, tarjeta_credito, microcredito)
- original_amount
- current_balance
- monthly_payment
- payment_day
- start_date
- end_date
- status (activo, pagado, mora, castigado)
- days_overdue
- reported_to_credit_bureau (boolean)
- created_at
- updated_at
```

### 7. **client_documents** (Documentación Digital)
```sql
- id (PK)
- client_id (FK)
- document_type (cedula_frontal, cedula_reverso, certificado_laboral, desprendible_pago,
                  extracto_bancario, servicio_publico, referencia_firmada, contrato, otro)
- file_name
- file_path (fuera de public/)
- file_size
- mime_type
- version (integer, para versionamiento)
- upload_date
- expiry_date (para documentos con vigencia)
- status (pendiente, en_revision, aprobado, rechazado)
- reviewed_by (FK a users)
- review_date
- review_comments
- is_current_version (boolean)
- uploaded_by (FK a users)
- created_at
- updated_at
- deleted_at
```

### 8. **client_bank_statements** (Estados de Cuenta)
```sql
- id (PK)
- client_id (FK)
- client_document_id (FK - referencia al PDF subido)
- bank_name
- account_type (ahorros, corriente)
- account_number_last4 (solo últimos 4 dígitos)
- statement_month
- statement_year
- opening_balance
- closing_balance
- average_balance (calculado)
- total_deposits
- total_withdrawals
- deposit_count
- withdrawal_count
- overdraft_count
- salary_detected (boolean)
- salary_amount (cifrado)
- analysis_status (pendiente, analizado)
- analyzed_at
- analyzed_by (FK a users)
- created_at
- updated_at
```

### 9. **client_bank_transactions** (Transacciones Bancarias Detalladas)
```sql
- id (PK)
- bank_statement_id (FK)
- transaction_date
- description
- transaction_type (deposito, retiro, transferencia, pago_servicio)
- amount
- balance
- is_recurrent (detectado automáticamente)
- category (salario, arriendo, servicios, alimentacion, otro)
- created_at
```

### 10. **client_midatacredito** (Consultas Midatacrédito)
```sql
- id (PK)
- client_id (FK)
- query_date
- query_type (consulta_completa, consulta_score)
- score
- risk_level (bajo, medio, alto, muy_alto)
- active_credits_count
- total_debt
- overdue_debt
- worst_status (al_dia, mora_30, mora_60, mora_90, mora_120, castigado)
- credit_cards_count
- last_query_date (última consulta registrada en centrales)
- inquiries_last_6_months
- has_legal_proceedings (boolean)
- response_json (almacena respuesta completa de API)
- queried_by (FK a users)
- created_at
```

### 11. **client_status_history** (Historial de Estados)
```sql
- id (PK)
- client_id (FK)
- previous_status
- new_status
- changed_by (FK a users)
- change_reason
- comments
- created_at
```

### 12. **client_notes** (Notas y Observaciones)
```sql
- id (PK)
- client_id (FK)
- note_type (general, llamada, reunion, seguimiento, alerta)
- note_content
- is_important (boolean)
- is_private (solo visible para analistas y superiores)
- created_by (FK a users)
- created_at
- updated_at
```

### 13. **client_consents** (Consentimientos Habeas Data)
```sql
- id (PK)
- client_id (FK)
- consent_type (tratamiento_datos, consulta_centrales, uso_comercial)
- consent_text (texto completo mostrado)
- accepted (boolean)
- acceptance_date
- acceptance_ip
- acceptance_user_agent
- revoked (boolean)
- revocation_date
- created_at
```

---

## 🔄 RELACIONES ENTRE ENTIDADES

```
clients (1) ──→ (N) client_contacts
clients (1) ──→ (N) client_employments
clients (1) ──→ (N) client_financials
clients (1) ──→ (N) client_references
clients (1) ──→ (N) client_credits
clients (1) ──→ (N) client_documents
clients (1) ──→ (N) client_bank_statements
clients (1) ──→ (N) client_midatacredito
clients (1) ──→ (N) client_status_history
clients (1) ──→ (N) client_notes
clients (1) ──→ (N) client_consents

client_bank_statements (1) ──→ (N) client_bank_transactions
client_bank_statements (1) ──→ (1) client_documents

users (1) ──→ (N) clients (como analista asignado)
users (1) ──→ (N) client_documents (como revisor)
users (1) ──→ (N) client_status_history (como autor del cambio)
users (1) ──→ (N) client_notes (como autor)
```

---

## 🎨 DISEÑO UI/UX - WIREFRAMES Y FLUJOS

### Vista Principal: Listado de Clientes

```
┌─────────────────────────────────────────────────────────────────┐
│ 📋 Gestión de Hojas de Vida de Clientes                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ [🔍 Buscar por documento, nombre, email...]  [+ Nuevo Cliente] │
│                                                                 │
│ Filtros: [Estado ▼] [Analista ▼] [Score ▼] [Fecha ▼]          │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│ 📊 Estadísticas Rápidas:                                        │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐               │
│ │  Total  │ │En Revisión│ │Aprobados│ │Rechazados│              │
│ │   245   │ │    48    │ │   180   │ │    17   │               │
│ └─────────┘ └─────────┘ └─────────┘ └─────────┘               │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ Tabla de Clientes (con scroll virtual):                        │
│ ┌──────────┬───────────────┬──────────┬─────────┬──────────┐   │
│ │ Documento│ Nombre        │ Estado   │ Score   │ Acciones │   │
│ ├──────────┼───────────────┼──────────┼─────────┼──────────┤   │
│ │1234567890│ Juan Pérez    │🟢Aprobado│  780    │👁 ✏️ 📄  │   │
│ │9876543210│ Ana García    │🟡Revisión│  650    │👁 ✏️ 📄  │   │
│ │5555555555│ Carlos López  │🔴Rechazado│  520   │👁 ✏️ 📄  │   │
│ └──────────┴───────────────┴──────────┴─────────┴──────────┘   │
│                                                                 │
│ Mostrando 1-20 de 245 │ ← 1 2 3 ... 13 →                       │
└─────────────────────────────────────────────────────────────────┘
```

### Vista Detallada: Hoja de Vida del Cliente

**Diseño con Tabs/Pestañas para organizar información:**

```
┌─────────────────────────────────────────────────────────────────┐
│ ← Volver │ Juan Andrés Pérez García (CC 1234567890)            │
│                                                                 │
│ Estado: 🟢 Aprobado │ Score: 780 │ Analista: María López       │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ [📝 Personal] [💼 Laboral] [💰 Financiero] [📞 Referencias]    │
│ [💳 Créditos] [📄 Documentos] [🏦 Estados Cuenta] [📊 Análisis]│
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│                    TAB: 📝 Información Personal                 │
│                                                                 │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ Datos Personales:                                           │ │
│ │                                                             │ │
│ │ Nombre completo: Juan Andrés Pérez García                  │ │
│ │ Fecha nacimiento: 15/03/1985 (38 años)                     │ │
│ │ Lugar nacimiento: Bogotá, Cundinamarca                      │ │
│ │ Estado civil: Casado                                        │ │
│ │ Género: Masculino                                           │ │
│ │ Nivel educativo: Profesional                                │ │
│ │ Personas a cargo: 2                                         │ │
│ │                                           [Editar]          │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ Contactos:                                                  │ │
│ │                                                             │ │
│ │ 📍 Residencia: Calle 45 #12-34, Chapinero, Bogotá          │ │
│ │ 📞 Celular: +57 300 123 4567 ✓verificado                   │ │
│ │ ☎️  Fijo: (1) 234 5678                                      │ │
│ │ ✉️  Email: juan.perez@email.com ✓verificado                │ │
│ │                                                             │ │
│ │ 🏢 Trabajo: Carrera 7 #80-20, Empresa XYZ                   │ │
│ │                                           [+ Agregar]       │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### Formulario Multi-Paso: Creación de Cliente

```
┌─────────────────────────────────────────────────────────────────┐
│            Registro de Nuevo Cliente - Paso 2 de 6             │
│                                                                 │
│ [✓ Personal] [● Contacto] [○ Laboral] [○ Financiero]          │
│                   [○ Referencias] [○ Documentos]                │
│ ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━                    │
│                    33% completado                               │
│                                                                 │
├─────────────────────────────────────────────────────────────────┤
│                  Información de Contacto                        │
│                                                                 │
│ Dirección de Residencia *                                      │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ Calle 45 #12-34                                             │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│ Barrio                          Ciudad *                        │
│ ┌────────────────────────┐      ┌──────────────────────────┐   │
│ │ Chapinero              │      │ Bogotá ▼                 │   │
│ └────────────────────────┘      └──────────────────────────┘   │
│                                                                 │
│ Departamento *                  País                            │
│ ┌────────────────────────┐      ┌──────────────────────────┐   │
│ │ Cundinamarca ▼         │      │ Colombia                 │   │
│ └────────────────────────┘      └──────────────────────────┘   │
│                                                                 │
│ Teléfono Celular *              Teléfono Fijo                   │
│ ┌────────────────────────┐      ┌──────────────────────────┐   │
│ │ +57 300 123 4567       │      │ (1) 234 5678             │   │
│ └────────────────────────┘      └──────────────────────────┘   │
│                                                                 │
│ Correo Electrónico *                                            │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ juan.perez@email.com                                        │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│                                                                 │
│               [← Anterior]          [Siguiente →]               │
│                         [Guardar Borrador]                      │
└─────────────────────────────────────────────────────────────────┘
```

### Modal: Revisión de Documento

```
┌─────────────────────────────────────────────────────────────────┐
│ Revisión de Documento                                      [✕]  │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ Tipo: Certificado Laboral                                      │
│ Cargado: 15/10/2025 10:30 AM                                   │
│ Cargado por: Ana García (Asesora)                              │
│                                                                 │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │                                                             │ │
│ │            [Vista previa del PDF]                           │ │
│ │                                                             │ │
│ │         CERTIFICADO LABORAL                                 │ │
│ │                                                             │ │
│ │         La empresa XYZ certifica que                        │ │
│ │         el señor Juan Pérez...                              │ │
│ │                                                             │ │
│ │                                     [⤓ Descargar]           │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│ Fecha de emisión: [15/09/2025] (Vigente ✓)                     │
│                                                                 │
│ Decisión:                                                       │
│ ○ Aprobar    ○ Rechazar    ○ Solicitar nueva versión           │
│                                                                 │
│ Comentarios:                                                    │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ El documento cumple con los requisitos...                   │ │
│ │                                                             │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│                      [Cancelar]  [Guardar Revisión]             │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔐 SEGURIDAD AVANZADA

### 1. **Cifrado de Datos Sensibles**

**Implementación con Laravel Crypt:**

```php
// En el modelo Client
use Illuminate\Support\Facades\Crypt;

protected $casts = [
    'monthly_salary' => 'encrypted',
    'total_income' => 'encrypted',
    'account_number' => 'encrypted',
];

// O manualmente:
public function setMonthlySalaryAttribute($value)
{
    $this->attributes['monthly_salary'] = Crypt::encryptString($value);
}

public function getMonthlySalaryAttribute($value)
{
    return Crypt::decryptString($value);
}
```

### 2. **Control de Acceso (Políticas)**

```php
// app/Policies/ClientPolicy.php
class ClientPolicy
{
    public function view(User $user, Client $client)
    {
        return $user->hasPermission('clients.view') ||
               $user->id === $client->assigned_analyst_id;
    }

    public function update(User $user, Client $client)
    {
        return $user->hasPermission('clients.edit') ||
               ($user->hasRole('asesor') && $user->id === $client->created_by);
    }

    public function approve(User $user, Client $client)
    {
        return $user->hasPermission('clients.approve');
    }

    public function viewFinancialData(User $user, Client $client)
    {
        return $user->hasAnyRole(['analista_credito', 'gerente_credito', 'admin']);
    }
}
```

### 3. **Validación y Sanitización**

```php
// En componente Livewire
public function rules()
{
    return [
        'document_number' => [
            'required',
            'string',
            'regex:/^[0-9]{6,12}$/',
            'unique:clients,document_number,' . $this->clientId
        ],
        'email' => [
            'required',
            'email:rfc,dns',
            'max:255',
            Rule::unique('client_contacts')->where(function ($query) {
                return $query->where('client_id', $this->clientId);
            })
        ],
        'phone_mobile' => [
            'required',
            'regex:/^\+?57\s?3[0-9]{9}$/'
        ],
        'monthly_salary' => [
            'required',
            'numeric',
            'min:1000000',
            'max:100000000'
        ]
    ];
}

protected $messages = [
    'document_number.regex' => 'El número de documento debe contener solo dígitos',
    'phone_mobile.regex' => 'El celular debe tener formato válido colombiano',
    'monthly_salary.min' => 'El salario debe ser al menos $1,000,000'
];

// Sanitización
public function updatedEmail($value)
{
    $this->email = filter_var($value, FILTER_SANITIZE_EMAIL);
}
```

### 4. **Auditoría Completa**

```php
// Trait para auditoría automática
trait Auditable
{
    protected static function bootAuditable()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();

            // Registrar cambios
            AuditLog::create([
                'user_id' => auth()->id(),
                'auditable_type' => get_class($model),
                'auditable_id' => $model->id,
                'action' => 'update',
                'old_values' => $model->getOriginal(),
                'new_values' => $model->getDirty(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        });
    }
}
```

### 5. **Almacenamiento Seguro de Archivos**

```php
// Configuración en config/filesystems.php
'disks' => [
    'client_documents' => [
        'driver' => 'local',
        'root' => storage_path('app/private/client_documents'),
        'visibility' => 'private',
    ],
],

// Subir documento con Livewire
public function uploadDocument()
{
    $this->validate([
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120' // 5MB
    ]);

    $path = $this->document->store('client_documents', 'client_documents');

    ClientDocument::create([
        'client_id' => $this->clientId,
        'document_type' => $this->documentType,
        'file_name' => $this->document->getClientOriginalName(),
        'file_path' => $path,
        'file_size' => $this->document->getSize(),
        'mime_type' => $this->document->getMimeType(),
        'uploaded_by' => auth()->id()
    ]);
}

// Descargar con URL firmada
Route::get('/clients/documents/{document}/download', [ClientDocumentController::class, 'download'])
    ->middleware(['auth', 'signed'])
    ->name('client.document.download');

public function download(ClientDocument $document)
{
    $this->authorize('view', $document->client);

    return Storage::disk('client_documents')->download(
        $document->file_path,
        $document->file_name
    );
}

// Generar URL firmada temporal (válida 30 min)
$url = URL::temporarySignedRoute(
    'client.document.download',
    now()->addMinutes(30),
    ['document' => $document->id]
);
```

### 6. **Protección CSRF y Rate Limiting**

```php
// Todos los componentes Livewire tienen protección CSRF automática

// Rate limiting para endpoints críticos
// app/Http/Kernel.php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\TrustProxies::class,
    ],
];

// routes/web.php
Route::post('/clients/{client}/midatacredito/query', [MidatacreditoController::class, 'query'])
    ->middleware('throttle:3,60'); // Máximo 3 consultas por hora
```

---

## ⚙️ VALIDACIONES Y REGLAS DE NEGOCIO

### Validaciones de Datos Personales
```php
- Documento único por tipo
- Edad mínima: 18 años
- Edad máxima: 75 años
- Email válido y verificable
- Celular colombiano (+57 3XX XXX XXXX)
```

### Validaciones Laborales
```php
- Antigüedad mínima en empleo actual: 3 meses (contrato indefinido) o 6 meses (independiente)
- Ingresos mínimos: 1 SMLV ($1,300,000 en 2025)
- Certificado laboral con máx 30 días de antigüedad
```

### Validaciones Financieras
```php
class FinancialRules
{
    const MAX_DEBT_TO_INCOME_RATIO = 0.50; // Máximo 50% de endeudamiento
    const MIN_DISPOSABLE_INCOME = 500000; // Mínimo $500k disponible

    public static function calculatePaymentCapacity($income, $expenses)
    {
        $disposableIncome = $income - $expenses;
        return $disposableIncome * 0.35; // Máximo 35% del ingreso disponible
    }

    public static function validateFinancialViability(Client $client)
    {
        $financial = $client->latestFinancial;

        if (!$financial) {
            return ['viable' => false, 'reason' => 'Sin información financiera'];
        }

        $debtRatio = $financial->debt_to_income_ratio;
        if ($debtRatio > self::MAX_DEBT_TO_INCOME_RATIO) {
            return ['viable' => false, 'reason' => 'Endeudamiento superior al 50%'];
        }

        if ($financial->disposable_income < self::MIN_DISPOSABLE_INCOME) {
            return ['viable' => false, 'reason' => 'Ingreso disponible insuficiente'];
        }

        return ['viable' => true];
    }
}
```

### Reglas de Aprobación
```php
class ApprovalRules
{
    public static function canAutoApprove(Client $client): bool
    {
        $checks = [
            'credit_score' => $client->credit_score >= 700,
            'no_overdue_debts' => $client->midatacredito->overdue_debt == 0,
            'stable_employment' => $client->currentEmployment->months_employed >= 6,
            'good_debt_ratio' => $client->latestFinancial->debt_to_income_ratio <= 0.35,
            'all_documents_approved' => $client->documents()->where('status', 'aprobado')->count() >= 5,
            'references_verified' => $client->references()->where('verification_status', 'verificada')->count() >= 2
        ];

        return !in_array(false, $checks, true);
    }

    public static function requiresManagerApproval(Client $client, $requestedAmount): bool
    {
        return $requestedAmount > 10000000 || // Créditos > $10M
               $client->credit_score < 650 ||
               $client->midatacredito->worst_status != 'al_dia';
    }
}
```

### Validación de Documentos
```php
class DocumentValidationRules
{
    const REQUIRED_DOCUMENTS = [
        'cedula_frontal',
        'cedula_reverso',
        'certificado_laboral',
        'desprendible_pago',
        'servicio_publico'
    ];

    const DOCUMENT_MAX_AGE = [
        'certificado_laboral' => 30, // días
        'desprendible_pago' => 60,
        'servicio_publico' => 60,
        'extracto_bancario' => 90
    ];

    public static function isDocumentValid(ClientDocument $document): bool
    {
        if (!isset(self::DOCUMENT_MAX_AGE[$document->document_type])) {
            return true; // Sin restricción de antigüedad
        }

        $maxAge = self::DOCUMENT_MAX_AGE[$document->document_type];
        $daysSinceUpload = $document->upload_date->diffInDays(now());

        return $daysSinceUpload <= $maxAge;
    }
}
```

---

## 🧩 COMPONENTES LIVEWIRE

### 1. **ClientList** (Listado con Filtros)

```php
// app/Http/Livewire/Clients/ClientList.php
namespace App\Http\Livewire\Clients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;

class ClientList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $analystFilter = '';
    public $scoreFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $clients = Client::query()
            ->with(['assignedAnalyst', 'latestFinancial'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('document_number', 'like', '%' . $this->search . '%')
                      ->orWhere('full_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->analystFilter, function ($query) {
                $query->where('assigned_analyst_id', $this->analystFilter);
            })
            ->when($this->scoreFilter, function ($query) {
                switch ($this->scoreFilter) {
                    case 'excellent':
                        $query->where('credit_score', '>=', 750);
                        break;
                    case 'good':
                        $query->whereBetween('credit_score', [650, 749]);
                        break;
                    case 'fair':
                        $query->whereBetween('credit_score', [550, 649]);
                        break;
                    case 'poor':
                        $query->where('credit_score', '<', 550);
                        break;
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(20);

        return view('livewire.clients.client-list', [
            'clients' => $clients,
            'stats' => $this->getStatistics()
        ]);
    }

    private function getStatistics()
    {
        return [
            'total' => Client::count(),
            'in_review' => Client::where('status', 'en_revision')->count(),
            'approved' => Client::where('status', 'aprobado')->count(),
            'rejected' => Client::where('status', 'rechazado')->count(),
        ];
    }
}
```

### 2. **ClientForm** (Formulario Multi-Paso)

```php
// app/Http/Livewire/Clients/ClientForm.php
namespace App\Http\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;

class ClientForm extends Component
{
    public $currentStep = 1;
    public $totalSteps = 6;

    // Step 1: Datos Personales
    public $document_type = 'CC';
    public $document_number;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $second_last_name;
    public $birth_date;
    public $gender;
    public $marital_status;
    public $education_level;
    public $dependents_count = 0;

    // Step 2: Contacto
    public $address;
    public $neighborhood;
    public $city;
    public $department;
    public $phone_mobile;
    public $phone_landline;
    public $email;

    // Step 3: Información Laboral
    public $employment_type;
    public $employer_name;
    public $position;
    public $monthly_salary;
    public $start_date;

    // Step 4: Financiero
    public $total_income;
    public $total_expenses;

    // Step 5: Referencias
    public $references = [];

    // Step 6: Consentimientos
    public $consent_data_treatment = false;
    public $consent_credit_query = false;

    protected $validationAttributes = [
        'document_number' => 'número de documento',
        'first_name' => 'primer nombre',
        'birth_date' => 'fecha de nacimiento',
        'phone_mobile' => 'teléfono celular',
    ];

    public function mount()
    {
        $this->references = [
            ['type' => 'personal', 'name' => '', 'phone' => ''],
            ['type' => 'personal', 'name' => '', 'phone' => ''],
            ['type' => 'familiar', 'name' => '', 'phone' => '']
        ];
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step <= $this->currentStep || $step == $this->currentStep + 1) {
            $this->currentStep = $step;
        }
    }

    private function validateCurrentStep()
    {
        $rules = $this->getStepRules($this->currentStep);
        $this->validate($rules);
    }

    private function getStepRules($step)
    {
        $allRules = [
            1 => [ // Datos Personales
                'document_type' => 'required|in:CC,CE,TI,PP',
                'document_number' => 'required|numeric|digits_between:6,12|unique:clients,document_number',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'birth_date' => 'required|date|before:-18 years|after:-75 years',
                'gender' => 'required|in:M,F,Otro',
                'marital_status' => 'required',
                'education_level' => 'required'
            ],
            2 => [ // Contacto
                'address' => 'required|string|max:255',
                'city' => 'required|string',
                'department' => 'required|string',
                'phone_mobile' => ['required', 'regex:/^\+?57\s?3[0-9]{9}$/'],
                'email' => 'required|email|unique:client_contacts,email'
            ],
            3 => [ // Laboral
                'employment_type' => 'required',
                'employer_name' => 'required|string|max:255',
                'position' => 'required|string|max:100',
                'monthly_salary' => 'required|numeric|min:1300000',
                'start_date' => 'required|date|before:today'
            ],
            4 => [ // Financiero
                'total_income' => 'required|numeric|min:1300000',
                'total_expenses' => 'required|numeric|max:' . ($this->total_income * 0.8)
            ],
            5 => [ // Referencias
                'references.*.name' => 'required|string|max:255',
                'references.*.phone' => 'required|string'
            ],
            6 => [ // Consentimientos
                'consent_data_treatment' => 'accepted',
                'consent_credit_query' => 'accepted'
            ]
        ];

        return $allRules[$step] ?? [];
    }

    public function saveDraft()
    {
        // Guardar borrador sin validar todos los campos
        session()->put('client_draft', $this->all());
        session()->flash('message', 'Borrador guardado exitosamente');
    }

    public function submit()
    {
        // Validar todos los pasos
        foreach (range(1, $this->totalSteps) as $step) {
            $this->validate($this->getStepRules($step));
        }

        DB::transaction(function () {
            // Crear cliente
            $client = Client::create([
                'document_type' => $this->document_type,
                'document_number' => $this->document_number,
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'second_last_name' => $this->second_last_name,
                'full_name' => trim("{$this->first_name} {$this->middle_name} {$this->last_name} {$this->second_last_name}"),
                'birth_date' => $this->birth_date,
                'gender' => $this->gender,
                'marital_status' => $this->marital_status,
                'education_level' => $this->education_level,
                'dependents_count' => $this->dependents_count,
                'status' => 'registro_inicial',
                'created_by' => auth()->id()
            ]);

            // Crear contacto
            $client->contacts()->create([
                'contact_type' => 'residencia',
                'address' => $this->address,
                'neighborhood' => $this->neighborhood,
                'city' => $this->city,
                'department' => $this->department,
                'phone_mobile' => $this->phone_mobile,
                'phone_landline' => $this->phone_landline,
                'email' => $this->email,
                'is_primary' => true
            ]);

            // Crear empleo
            $client->employments()->create([
                'is_current' => true,
                'employment_type' => $this->employment_type,
                'employer_name' => $this->employer_name,
                'position' => $this->position,
                'monthly_salary' => $this->monthly_salary,
                'start_date' => $this->start_date
            ]);

            // Crear información financiera
            $client->financials()->create([
                'month_year' => now()->format('Y-m'),
                'total_income' => $this->total_income,
                'salary_income' => $this->monthly_salary,
                'total_expenses' => $this->total_expenses,
                'disposable_income' => $this->total_income - $this->total_expenses
            ]);

            // Crear referencias
            foreach ($this->references as $ref) {
                $client->references()->create([
                    'reference_type' => $ref['type'],
                    'full_name' => $ref['name'],
                    'phone' => $ref['phone'],
                    'verification_status' => 'pendiente'
                ]);
            }

            // Registrar consentimientos
            $client->consents()->create([
                'consent_type' => 'tratamiento_datos',
                'consent_text' => config('consents.data_treatment_text'),
                'accepted' => true,
                'acceptance_date' => now(),
                'acceptance_ip' => request()->ip()
            ]);

            $client->consents()->create([
                'consent_type' => 'consulta_centrales',
                'consent_text' => config('consents.credit_query_text'),
                'accepted' => true,
                'acceptance_date' => now(),
                'acceptance_ip' => request()->ip()
            ]);

            session()->forget('client_draft');

            return redirect()->route('clients.show', $client)
                ->with('success', 'Cliente registrado exitosamente');
        });
    }

    public function render()
    {
        return view('livewire.clients.client-form');
    }
}
```

### 3. **DocumentUpload** (Carga de Documentos)

```php
// app/Http/Livewire/Clients/DocumentUpload.php
namespace App\Http\Livewire\Clients;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\ClientDocument;
use Illuminate\Support\Facades\Storage;

class DocumentUpload extends Component
{
    use WithFileUploads;

    public Client $client;
    public $document;
    public $document_type;
    public $uploading = false;
    public $uploadProgress = 0;

    protected $rules = [
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'document_type' => 'required|in:cedula_frontal,cedula_reverso,certificado_laboral,desprendible_pago,extracto_bancario,servicio_publico,referencia_firmada,contrato,otro'
    ];

    public function uploadDocument()
    {
        $this->validate();

        $this->uploading = true;

        try {
            // Comprimir imagen si es necesario
            if (in_array($this->document->getMimeType(), ['image/jpeg', 'image/png'])) {
                $this->document = $this->compressImage($this->document);
            }

            $path = $this->document->store('client_documents', 'client_documents');

            // Obtener versión actual
            $currentVersion = ClientDocument::where('client_id', $this->client->id)
                ->where('document_type', $this->document_type)
                ->max('version') ?? 0;

            // Marcar versiones anteriores como no actuales
            ClientDocument::where('client_id', $this->client->id)
                ->where('document_type', $this->document_type)
                ->update(['is_current_version' => false]);

            // Crear nuevo registro
            $document = ClientDocument::create([
                'client_id' => $this->client->id,
                'document_type' => $this->document_type,
                'file_name' => $this->document->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $this->document->getSize(),
                'mime_type' => $this->document->getMimeType(),
                'version' => $currentVersion + 1,
                'upload_date' => now(),
                'status' => 'pendiente',
                'is_current_version' => true,
                'uploaded_by' => auth()->id()
            ]);

            // Emitir evento para actualizar lista de documentos
            $this->emit('documentUploaded', $document->id);

            session()->flash('message', 'Documento cargado exitosamente');

            // Limpiar formulario
            $this->reset(['document', 'document_type']);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar documento: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
        }
    }

    private function compressImage($file)
    {
        // Implementación de compresión de imagen
        // Usar Intervention Image u otra librería
        return $file;
    }

    public function render()
    {
        $requiredDocuments = [
            'cedula_frontal' => 'Cédula - Frontal',
            'cedula_reverso' => 'Cédula - Reverso',
            'certificado_laboral' => 'Certificado Laboral',
            'desprendible_pago' => 'Desprendible de Pago',
            'extracto_bancario' => 'Extracto Bancario',
            'servicio_publico' => 'Recibo Servicio Público'
        ];

        $uploadedDocuments = $this->client->documents()
            ->where('is_current_version', true)
            ->get()
            ->keyBy('document_type');

        return view('livewire.clients.document-upload', [
            'requiredDocuments' => $requiredDocuments,
            'uploadedDocuments' => $uploadedDocuments
        ]);
    }
}
```

### 4. **DocumentReview** (Revisión de Documentos)

```php
// app/Http/Livewire/Clients/DocumentReview.php
namespace App\Http\Livewire\Clients;

use Livewire\Component;
use App\Models\ClientDocument;

class DocumentReview extends Component
{
    public ClientDocument $document;
    public $showModal = false;
    public $decision;
    public $reviewComments;

    protected $listeners = ['openReviewModal'];

    public function openReviewModal($documentId)
    {
        $this->document = ClientDocument::findOrFail($documentId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['decision', 'reviewComments']);
    }

    public function submitReview()
    {
        $this->validate([
            'decision' => 'required|in:aprobar,rechazar,solicitar_nueva',
            'reviewComments' => 'required_if:decision,rechazar,solicitar_nueva|string|max:500'
        ]);

        $status = match($this->decision) {
            'aprobar' => 'aprobado',
            'rechazar' => 'rechazado',
            'solicitar_nueva' => 'pendiente'
        };

        $this->document->update([
            'status' => $status,
            'reviewed_by' => auth()->id(),
            'review_date' => now(),
            'review_comments' => $this->reviewComments
        ]);

        // Crear nota en hoja de vida
        $this->document->client->notes()->create([
            'note_type' => 'seguimiento',
            'note_content' => "Documento {$this->document->document_type} {$status}. " . $this->reviewComments,
            'created_by' => auth()->id()
        ]);

        // Notificar al asesor
        if ($status === 'rechazado') {
            // Implementar notificación
        }

        $this->emit('documentReviewed');
        session()->flash('message', 'Revisión guardada exitosamente');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.clients.document-review');
    }
}
```

### 5. **MidatacreditoQuery** (Consulta Midatacrédito)

```php
// app/Http/Livewire/Clients/MidatacreditoQuery.php
namespace App\Http\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use App\Services\MidatacreditoService;

class MidatacreditoQuery extends Component
{
    public Client $client;
    public $querying = false;
    public $lastQuery;

    public function mount()
    {
        $this->lastQuery = $this->client->midatacredito()->latest()->first();
    }

    public function performQuery()
    {
        $this->authorize('query-midatacredito', $this->client);

        $this->querying = true;

        try {
            $service = new MidatacreditoService();
            $result = $service->queryClient($this->client);

            $this->client->midatacredito()->create([
                'query_date' => now(),
                'query_type' => 'consulta_completa',
                'score' => $result['score'],
                'risk_level' => $result['risk_level'],
                'active_credits_count' => $result['active_credits_count'],
                'total_debt' => $result['total_debt'],
                'overdue_debt' => $result['overdue_debt'],
                'worst_status' => $result['worst_status'],
                'response_json' => json_encode($result),
                'queried_by' => auth()->id()
            ]);

            // Actualizar score del cliente
            $this->client->update([
                'credit_score' => $result['score']
            ]);

            $this->lastQuery = $this->client->midatacredito()->latest()->first();

            session()->flash('message', 'Consulta realizada exitosamente');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al consultar Midatacrédito: ' . $e->getMessage());
        } finally {
            $this->querying = false;
        }
    }

    public function render()
    {
        return view('livewire.clients.midatacredito-query');
    }
}
```

---

## 📊 FLUJO COMPLETO DEL MÓDULO

### Flujo de Registro de Cliente

```
1. INICIO
   ↓
2. Asesor Comercial ingresa a "Nuevo Cliente"
   ↓
3. Formulario Multi-Paso (6 pasos):
   │
   ├── Paso 1: Datos Personales
   │   • Validar documento único
   │   • Validar edad (18-75 años)
   │   • Autoguardado de borrador
   │
   ├── Paso 2: Información de Contacto
   │   • Validar email único
   │   • Validar formato celular colombiano
   │   • Autocompletar ciudad/departamento
   │
   ├── Paso 3: Información Laboral
   │   • Validar ingresos mínimos (1 SMLV)
   │   • Calcular antigüedad laboral
   │
   ├── Paso 4: Información Financiera
   │   • Calcular relación ingreso/egreso
   │   • Validar capacidad de pago
   │   • Alertas si ratio > 50%
   │
   ├── Paso 5: Referencias
   │   • Mínimo 2 personales + 1 familiar
   │   • Validar datos de contacto
   │
   └── Paso 6: Consentimientos
       • Aceptar tratamiento de datos (obligatorio)
       • Aceptar consulta centrales (obligatorio)
       • Registrar IP y timestamp
   ↓
4. GUARDAR Cliente (estado: registro_inicial)
   ↓
5. Redirigir a Hoja de Vida del Cliente
   ↓
6. Solicitar carga de documentos
```

### Flujo de Evaluación Crediticia

```
1. Cliente en estado "registro_inicial"
   ↓
2. Analista de Crédito asignado revisa documentos
   │
   ├── ¿Todos los documentos aprobados?
   │   NO → Solicitar documentos faltantes
   │   │     Enviar notificación al asesor
   │   │     Estado: "documentacion_pendiente"
   │   │     PAUSAR evaluación
   │   │
   │   SÍ → Continuar
   ↓
3. Verificar Referencias
   │   • Llamar a referencias personales
   │   • Validar datos proporcionados
   │   • Registrar resultado de verificación
   │
   ├── ¿Referencias verificadas positivamente?
   │   NO → Rechazar solicitud
   │   │     Registrar motivo
   │   │     Estado: "rechazado"
   │   │     FIN
   │   │
   │   SÍ → Continuar
   ↓
4. Consultar Midatacrédito
   │   • Obtener score crediticio
   │   • Verificar créditos activos
   │   • Verificar reportes de mora
   │
   ├── ¿Score >= 600 y sin moras?
   │   NO → Evaluación manual gerente
   │   │     Estado: "en_revision_gerencia"
   │   │
   │   SÍ → Continuar
   ↓
5. Análisis Financiero
   │   • Revisar extractos bancarios
   │   • Validar ingresos declarados vs extractos
   │   • Calcular capacidad de pago
   │
   ├── ¿Capacidad de pago suficiente?
   │   NO → Rechazar o ajustar monto
   │   │
   │   SÍ → Continuar
   ↓
6. Decisión Automática de Aprobación
   │
   ├── SI cumple todos los criterios:
   │   • Score >= 700
   │   • Sin deudas vencidas
   │   • Empleo estable (6+ meses)
   │   • Relación deuda/ingreso <= 35%
   │   • Todos documentos aprobados
   │   • 2+ referencias verificadas
   │   │
   │   ENTONCES: Auto-aprobar
   │   Estado: "aprobado"
   │   Generar contrato
   │   FIN
   │
   └── SI NO cumple criterios automáticos:
       Requiere aprobación manual
       │
       ├── Monto > $10M o Score < 650?
       │   SÍ → Aprobación Gerente
       │   NO → Aprobación Analista
       │
       └── Decisión manual
           ├── APROBAR → Estado: "aprobado"
           │              Generar contrato
           │              FIN
           │
           └── RECHAZAR → Estado: "rechazado"
                          Registrar motivo
                          FIN
```

### Flujo de Actualización de Información

```
1. Cliente o Asesor actualiza datos
   ↓
2. Validar permisos de actualización
   ├── Cliente: Solo puede actualizar contacto básico
   ├── Asesor: Puede actualizar todo excepto decisión de crédito
   └── Analista: Puede actualizar todo
   ↓
3. Validar datos ingresados
   ↓
4. Guardar cambios en BD
   ↓
5. Registrar en audit_log
   │   • Usuario que modificó
   │   • Campos modificados (antes/después)
   │   • Timestamp
   │   • IP address
   ↓
6. SI cambio afecta evaluación crediticia:
   │   • Re-evaluar automáticamente
   │   • Actualizar score si aplica
   │   • Notificar a analista asignado
   ↓
7. Confirmar actualización al usuario
```

---

## 📁 ESTRUCTURA DE DIRECTORIOS

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ClientController.php
│   ├── Livewire/
│   │   └── Clients/
│   │       ├── ClientList.php
│   │       ├── ClientForm.php
│   │       ├── ClientView.php
│   │       ├── DocumentUpload.php
│   │       ├── DocumentReview.php
│   │       ├── FinancialAnalysis.php
│   │       ├── MidatacreditoQuery.php
│   │       └── ReferenceVerification.php
│   └── Requests/
│       ├── StoreClientRequest.php
│       └── UpdateClientRequest.php
├── Models/
│   ├── Client.php
│   ├── ClientContact.php
│   ├── ClientEmployment.php
│   ├── ClientFinancial.php
│   ├── ClientReference.php
│   ├── ClientCredit.php
│   ├── ClientDocument.php
│   ├── ClientBankStatement.php
│   ├── ClientMidatacredito.php
│   ├── ClientStatusHistory.php
│   ├── ClientNote.php
│   └── ClientConsent.php
├── Services/
│   ├── MidatacreditoService.php
│   ├── FinancialAnalysisService.php
│   ├── DocumentAnalysisService.php
│   └── ClientApprovalService.php
├── Policies/
│   └── ClientPolicy.php
├── Observers/
│   └── ClientObserver.php
└── Rules/
    ├── ValidColombianPhone.php
    ├── MinimumAge.php
    └── MaximumDebtRatio.php

database/
└── migrations/
    ├── 2025_01_01_000001_create_clients_table.php
    ├── 2025_01_01_000002_create_client_contacts_table.php
    ├── 2025_01_01_000003_create_client_employments_table.php
    ├── 2025_01_01_000004_create_client_financials_table.php
    ├── 2025_01_01_000005_create_client_references_table.php
    ├── 2025_01_01_000006_create_client_credits_table.php
    ├── 2025_01_01_000007_create_client_documents_table.php
    ├── 2025_01_01_000008_create_client_bank_statements_table.php
    ├── 2025_01_01_000009_create_client_bank_transactions_table.php
    ├── 2025_01_01_000010_create_client_midatacredito_table.php
    ├── 2025_01_01_000011_create_client_status_history_table.php
    ├── 2025_01_01_000012_create_client_notes_table.php
    └── 2025_01_01_000013_create_client_consents_table.php

resources/
└── views/
    ├── livewire/
    │   └── clients/
    │       ├── client-list.blade.php
    │       ├── client-form.blade.php
    │       ├── client-view.blade.php
    │       ├── document-upload.blade.php
    │       ├── document-review.blade.php
    │       ├── financial-analysis.blade.php
    │       ├── midatacredito-query.blade.php
    │       └── reference-verification.blade.php
    └── clients/
        ├── index.blade.php
        ├── create.blade.php
        ├── show.blade.php
        └── partials/
            ├── personal-info.blade.php
            ├── employment-info.blade.php
            ├── financial-info.blade.php
            ├── references.blade.php
            ├── credits-history.blade.php
            ├── documents.blade.php
            └── status-timeline.blade.php

routes/
└── web.php
    ├── Rutas de clientes
    ├── Rutas de documentos
    └── Rutas de consultas Midatacrédito
```

---

## 🎯 RESUMEN FINAL DEL MÓDULO

### **Funcionalidades Principales**

1. ✅ Registro completo de clientes (6 pasos)
2. ✅ Gestión de información personal, laboral y financiera
3. ✅ Sistema de carga y revisión de documentos
4. ✅ Integración con Midatacrédito para consultas crediticias
5. ✅ Análisis automático de estados de cuenta bancarios
6. ✅ Verificación de referencias personales y comerciales
7. ✅ Flujo de aprobación automatizado con reglas de negocio
8. ✅ Control de acceso basado en roles (RBAC)
9. ✅ Cifrado de datos sensibles (salarios, cuentas bancarias)
10. ✅ Auditoría completa de cambios
11. ✅ Búsqueda y filtros avanzados
12. ✅ Dashboards con estadísticas en tiempo real
13. ✅ Notificaciones automáticas por cambios de estado
14. ✅ Exportación de reportes (Excel/PDF)
15. ✅ Gestión de consentimientos (Habeas Data)

### **Tecnologías Utilizadas**

- **Backend**: Laravel 10.x
- **Frontend interactivo**: Livewire 3.x
- **UI Framework**: Tailwind CSS
- **Base de datos**: MySQL 8.0
- **Almacenamiento archivos**: Laravel Storage (local/S3)
- **Colas**: Laravel Queues para procesos pesados
- **Cifrado**: AES-256 (Laravel Crypt)
- **API Externa**: Midatacrédito REST API

### **Próximos Pasos de Implementación**

1. Crear migraciones de base de datos
2. Implementar modelos Eloquent con relaciones
3. Desarrollar componentes Livewire
4. Crear vistas con diseño UI/UX avanzado
5. Implementar servicios de integración (Midatacrédito)
6. Configurar permisos y políticas de acceso
7. Implementar pruebas unitarias y de integración
8. Documentar API y flujos de trabajo

**¿Deseas que proceda con la implementación de alguna parte específica del módulo?**
