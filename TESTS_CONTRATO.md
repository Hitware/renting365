# Pruebas del Formulario de Contrato

## Resumen de Cambios Realizados

### 1. Modelo Motorcycle
✅ Actualizado `$fillable` con campos correctos de la BD:
- `displacement`, `motor_number`, `chassis_number`
- `purchase_date`, `created_by`, `updated_by`
- Eliminados campos inexistentes: `vin`, `engine_capacity`

### 2. Componente ContractForm
✅ Agregados campos obligatorios:
- `plate` (obligatorio)
- `motor_number` (obligatorio)
- `chassis_number` (obligatorio)

✅ Validación mejorada:
- Reglas convertidas a método `rules()` dinámico
- Agregada validación `min:1` para evitar strings vacíos
- Mensajes personalizados en español
- Validación en tiempo real con `validateOnly()`

✅ Limpieza de datos:
- Método para convertir strings vacíos a NULL antes de guardar
- Previene errores de integridad en la BD

### 3. Vista del Formulario
✅ Campos actualizados:
- Agregados inputs para número de motor y chasis
- Placa marcada como obligatoria
- Validación en tiempo real con `wire:model.blur`
- Atributo HTML `required` agregado

## Pruebas Realizadas (Sin Afectar BD)

### ✅ Test 1: Validación de Campos Vacíos
```
Resultado: CORRECTO
- Detecta cuando plate está vacío
- Muestra mensaje de error personalizado
- Previene guardado con datos incompletos
```

### ✅ Test 2: Validación de Campos Completos
```
Resultado: CORRECTO
- Acepta datos válidos
- Todos los campos pasan validación
```

### ✅ Test 3: Creación de Motocicleta
```
Resultado: CORRECTO
- Moto creada exitosamente con todos los campos
- Campos guardados: brand, model, year, plate, motor_number, chassis_number, color, displacement
- Transacción revertida - BD no afectada
```

### ✅ Test 4: Flujo Completo de Contrato
```
Resultado: CORRECTO
- Cliente verificado
- Motocicleta creada
- Contrato creado
- Relaciones correctas (client, motorcycle)
- Transacción revertida - BD no afectada
```

## Campos Obligatorios en la BD

Según estructura de `motorcycles`:
- ✅ `brand` - NOT NULL
- ✅ `model` - NOT NULL
- ✅ `year` - NOT NULL
- ✅ `displacement` - NOT NULL
- ✅ `plate` - NOT NULL
- ✅ `motor_number` - NOT NULL
- ✅ `chassis_number` - NOT NULL
- ✅ `status` - NOT NULL (default: 'active')

Campos opcionales:
- `color` - NULL permitido
- `current_owner_id` - NULL permitido
- `purchase_price` - NULL permitido
- `purchase_date` - NULL permitido
- `notes` - NULL permitido

## Solución Implementada

### Problema Original
El campo `plate` llegaba como string vacío `""` desde Livewire, lo que causaba error de integridad en MySQL porque la columna no permite NULL.

### Solución
1. **Validación estricta**: Agregada regla `min:1` para rechazar strings vacíos
2. **Limpieza de datos**: Convertir strings vacíos a NULL antes de validar
3. **Validación en tiempo real**: Detectar errores mientras el usuario llena el formulario
4. **Mensajes claros**: Errores en español que indican exactamente qué falta

## Cómo Usar el Formulario

1. Seleccionar cliente
2. Llenar datos de la moto:
   - Marca (ej: AUTECO)
   - Modelo (ej: TVS 100)
   - Año (ej: 2025)
   - **Placa (obligatorio)** (ej: ABC123)
   - **Número de Motor (obligatorio)** (ej: MOTOR123)
   - **Número de Chasis (obligatorio)** (ej: CHASIS123)
   - Color (ej: NEGRO)
   - Cilindraje (ej: 100)
3. Configurar términos del contrato
4. Subir PDF firmado
5. Guardar

## Correcciones Adicionales

### Problema 1: Placa Duplicada
**Error**: `Duplicate entry 'ABC123' for key 'motorcycles.motorcycles_plate_unique'`

**Solución**:
- ✅ Validación en tiempo real con `updatedPlate()`
- ✅ Regla `unique` en validación del formulario
- ✅ Ignora la moto actual al editar
- ✅ Mensaje de error inmediato al escribir placa duplicada

### Problema 2: Campo 'principal' Faltante
**Error**: `Field 'principal' doesn't have a default value`

**Solución**:
- ✅ Agregado campo `principal` en generación de pagos
- ✅ Agregado campo `interest` (siempre 0 porque no hay intereses)
- ✅ Estructura completa: payment_number, due_date, amount, principal, interest, balance

## Verificación Final

✅ Todos los tests pasaron exitosamente
✅ Base de datos NO fue afectada durante las pruebas
✅ Validaciones funcionan correctamente
✅ Validación de placa duplicada en tiempo real
✅ Pagos se crean con todos los campos requeridos
✅ Guardado funciona con datos completos
✅ Mensajes de error claros y en español
