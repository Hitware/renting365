# Sistema de Programación de Mantenimientos

## Componentes Implementados

### 1. ScheduleMaintenance (✅ Completado)
- **Ubicación**: `app/Livewire/Maintenance/ScheduleMaintenance.php`
- **Función**: Formulario modal para programar mantenimientos
- **Características**:
  - Tipos: Preventivo, Correctivo, Inspección, Otro
  - Validación de fechas (no permite fechas pasadas)
  - Asociación con contrato y motocicleta
  - Campos: título, descripción, fecha, taller, costo estimado, notas

### 2. MaintenanceCalendar (Pendiente)
- **Ubicación**: `app/Livewire/Maintenance/MaintenanceCalendar.php`
- **Función**: Vista de calendario con mantenimientos programados
- **Características**:
  - Vista mensual con mantenimientos por día
  - Filtros por estado y tipo
  - Click en día para ver detalles
  - Indicadores de color por estado

### 3. MaintenanceHistory (Pendiente)
- **Ubicación**: `app/Livewire/Maintenance/MaintenanceHistory.php`
- **Función**: Historial de mantenimientos por motocicleta
- **Características**:
  - Lista cronológica de mantenimientos
  - Filtros por tipo y estado
  - Detalles completos de cada mantenimiento
  - Costos totales

## Estructura de Base de Datos

### Tabla: motorcycle_maintenances
- `id`: ID único
- `motorcycle_id`: Moto asociada (requerido)
- `leasing_contract_id`: Contrato asociado (opcional)
- `type`: Tipo (preventive, corrective, inspection, other)
- `title`: Título del mantenimiento
- `description`: Descripción detallada
- `scheduled_date`: Fecha programada
- `completed_date`: Fecha de completado
- `status`: Estado (pending, in_progress, completed, cancelled)
- `workshop_name`: Nombre del taller
- `technician_name`: Nombre del técnico
- `estimated_cost`: Costo estimado
- `actual_cost`: Costo real
- `mileage_km`: Kilometraje
- `next_maintenance_date`: Próximo mantenimiento
- `next_maintenance_km`: Próximo kilometraje
- `notes`: Notas adicionales
- `registered_by`: Usuario que registró

## Flujo de Uso

### Para Clientes:
1. Ver su contrato en `/leasing-contracts/{id}`
2. Click en "Programar Mantenimiento"
3. Llenar formulario con detalles
4. Sistema crea mantenimiento con estado "pending"
5. Ver mantenimientos programados en su contrato

### Para Administradores/Asesores:
1. Acceder a `/maintenance/calendar`
2. Ver todos los mantenimientos programados
3. Filtrar por fecha, estado, tipo
4. Actualizar estado de mantenimientos
5. Ver historial completo por moto

## Permisos Requeridos

- `maintenance.view`: Ver mantenimientos
- `maintenance.create`: Programar mantenimientos
- `maintenance.update`: Actualizar mantenimientos
- `maintenance.delete`: Cancelar mantenimientos

## Próximos Pasos

1. ✅ Implementar ScheduleMaintenance
2. ⏳ Implementar MaintenanceCalendar
3. ⏳ Implementar MaintenanceHistory
4. ⏳ Agregar botón en vista de contrato
5. ⏳ Crear rutas y controladores
6. ⏳ Implementar tests unitarios

## Tests a Realizar

1. **Test de Programación**:
   - Crear mantenimiento con datos válidos
   - Validar campos requeridos
   - Verificar fechas futuras

2. **Test de Calendario**:
   - Cargar mantenimientos del mes
   - Filtrar por estado
   - Verificar permisos

3. **Test de Historial**:
   - Listar mantenimientos por moto
   - Verificar orden cronológico
   - Calcular costos totales

4. **Test de Permisos**:
   - Cliente solo ve sus mantenimientos
   - Admin ve todos
   - Asesor ve asignados
