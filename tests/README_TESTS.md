# Pruebas Unitarias - Renting365

## Resumen de Pruebas Implementadas

Se han creado pruebas unitarias para validar las funcionalidades principales implementadas en el sistema.

### Pruebas Exitosas ✅

#### 1. ClientPermissionsTest (8 pruebas - 100% exitosas)
**Ubicación:** `tests/Unit/ClientPermissionsTest.php`

Valida el sistema de permisos para usuarios con rol de cliente:

- ✅ `cliente_tiene_permiso_ver_propios_contratos` - Verifica que clientes puedan ver sus contratos
- ✅ `cliente_tiene_permiso_ver_propios_pagos` - Verifica que clientes puedan ver sus pagos
- ✅ `cliente_tiene_permiso_ver_propia_cuenta` - Verifica que clientes puedan ver su estado de cuenta
- ✅ `cliente_no_tiene_permiso_crear_contratos` - Verifica que clientes NO puedan crear contratos
- ✅ `cliente_no_tiene_permiso_editar_contratos` - Verifica que clientes NO puedan editar contratos
- ✅ `cliente_no_tiene_permiso_eliminar_contratos` - Verifica que clientes NO puedan eliminar contratos
- ✅ `admin_tiene_todos_los_permisos` - Verifica que administradores tengan todos los permisos
- ✅ `usuario_sin_rol_no_tiene_permisos` - Verifica que usuarios sin rol no tengan permisos

**Ejecutar:**
```bash
php artisan test tests/Unit/ClientPermissionsTest.php
```

#### 2. PaymentFrequencyTest (8 pruebas - 100% exitosas)
**Ubicación:** `tests/Unit/PaymentFrequencyTest.php`

Valida el cálculo de fechas de pago según diferentes frecuencias:

- ✅ `calcula_fecha_siguiente_pago_diario` - Valida cálculo para pagos diarios
- ✅ `calcula_fecha_siguiente_pago_semanal` - Valida cálculo para pagos semanales
- ✅ `calcula_fecha_siguiente_pago_quincenal` - Valida cálculo para pagos quincenales
- ✅ `calcula_fecha_siguiente_pago_mensual` - Valida cálculo para pagos mensuales
- ✅ `calcula_multiples_pagos_diarios` - Valida secuencia de 5 pagos diarios
- ✅ `calcula_multiples_pagos_semanales` - Valida secuencia de 4 pagos semanales
- ✅ `calcula_multiples_pagos_quincenales` - Valida secuencia de 3 pagos quincenales
- ✅ `calcula_multiples_pagos_mensuales` - Valida secuencia de 6 pagos mensuales

**Ejecutar:**
```bash
php artisan test tests/Unit/PaymentFrequencyTest.php
```

### Pruebas Pendientes ⏳

#### 3. LeasingContractFrequencyTest
**Ubicación:** `tests/Feature/LeasingContractFrequencyTest.php`
**Estado:** Requiere ajustes en factories (MotorcycleFactory y ClientFactory)

#### 4. ContractAuthorizationTest
**Ubicación:** `tests/Feature/ContractAuthorizationTest.php`
**Estado:** Requiere ajustes en factories

#### 5. PaymentAuthorizationTest
**Ubicación:** `tests/Feature/PaymentAuthorizationTest.php`
**Estado:** Requiere ajustes en factories

## Ejecutar Todas las Pruebas Exitosas

```bash
php artisan test tests/Unit/ClientPermissionsTest.php tests/Unit/PaymentFrequencyTest.php
```

## Resultados

```
PASS  Tests\Unit\ClientPermissionsTest
✓ 8 pruebas pasadas (8 assertions)

PASS  Tests\Unit\PaymentFrequencyTest  
✓ 8 pruebas pasadas (15 assertions)

Total: 16 pruebas pasadas (23 assertions)
```

## Cobertura de Funcionalidades

### ✅ Sistema de Permisos
- Permisos de cliente (view-own)
- Permisos de administrador (view, create, edit)
- Restricciones de acceso por rol

### ✅ Frecuencia de Pagos
- Cálculo de fechas para pagos diarios
- Cálculo de fechas para pagos semanales
- Cálculo de fechas para pagos quincenales
- Cálculo de fechas para pagos mensuales
- Generación de secuencias de pagos

### ⏳ Pendiente
- Autorización de contratos por cliente
- Autorización de pagos por cliente
- Creación de contratos con diferentes frecuencias

## Factories Creados

- ✅ `ClientFactory` - Genera clientes de prueba
- ✅ `MotorcycleFactory` - Genera motocicletas de prueba
- ✅ `LeasingContractFactory` - Genera contratos de prueba
- ✅ `PaymentFactory` (LeasingPayment) - Genera pagos de prueba

## Notas Técnicas

1. Las pruebas utilizan SQLite en memoria para mayor velocidad
2. Se ejecuta el seeder `RolesAndPermissionsSeeder` antes de cada prueba
3. Se utiliza `RefreshDatabase` trait para limpiar la base de datos entre pruebas
4. Los factories requieren ajustes para coincidir con la estructura real de las tablas

## Próximos Pasos

1. Ajustar MotorcycleFactory para usar campos correctos (vin en lugar de engine_number, etc.)
2. Ajustar ClientFactory para usar valores válidos de education_level según CHECK constraint
3. Completar pruebas de autorización de contratos y pagos
4. Agregar pruebas de integración para flujos completos
