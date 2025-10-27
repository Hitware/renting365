# Troubleshooting: Botón "Siguiente" no funciona

## Cambios Realizados

### 1. **Agregado wire:click.prevent**
Se agregó el modificador `.prevent` para evitar el comportamiento por defecto del botón:
```blade
wire:click.prevent="nextStep"
```

### 2. **Agregado indicador de carga**
Ahora el botón muestra "Procesando..." mientras se ejecuta la validación:
```blade
<span wire:loading wire:target="nextStep">Procesando...</span>
```

### 3. **Agregado manejo de excepciones**
El método `nextStep()` ahora captura y maneja correctamente las excepciones de validación.

### 4. **Agregado display de errores**
Se agregó un bloque que muestra todos los errores de validación en la parte superior del formulario.

---

## Cómo Verificar el Problema

### Paso 1: Abrir la Consola del Navegador
1. Presiona `F12` o `Cmd+Option+I` (Mac)
2. Ve a la pestaña "Console"
3. Intenta hacer click en "Siguiente"
4. Observa si aparecen errores en rojo

### Paso 2: Verificar la Pestaña Network
1. En las herramientas de desarrollador, ve a "Network"
2. Filtra por "Fetch/XHR"
3. Haz click en "Siguiente"
4. Verifica si se hace una petición a Livewire
5. Si hay una petición, revisa la respuesta

### Paso 3: Verificar Errores de Validación
1. Completa TODOS los campos obligatorios del Paso 1:
   - Tipo de documento
   - Número de documento
   - Primer nombre
   - Primer apellido
   - Fecha de nacimiento
   - Género
   - Estado civil
   - Nivel educativo

2. Intenta avanzar nuevamente

---

## Posibles Causas y Soluciones

### Causa 1: Errores de Validación
**Síntoma**: El botón no hace nada o muestra errores
**Solución**: Completa todos los campos obligatorios marcados con *

**Campos obligatorios del Paso 1:**
- ✅ Tipo de Documento
- ✅ Número de Documento (6-12 dígitos)
- ✅ Primer Nombre
- ✅ Primer Apellido
- ✅ Fecha de Nacimiento (entre 18 y 75 años)
- ✅ Género
- ✅ Estado Civil
- ✅ Nivel Educativo

### Causa 2: JavaScript no cargado
**Síntoma**: El botón no responde en absoluto
**Solución**: 
```bash
# Limpiar caché
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Reiniciar servidor
php artisan serve
```

### Causa 3: Livewire no inicializado
**Síntoma**: Error en consola "Livewire is not defined"
**Solución**: Verificar que en `app.blade.php` estén estas líneas:
```blade
@livewireStyles
<!-- contenido -->
@livewireScripts
```

### Causa 4: Conflicto con Alpine.js
**Síntoma**: Errores relacionados con Alpine en consola
**Solución**: Verificar que Alpine.js se carga DESPUÉS de Livewire

---

## Comandos de Diagnóstico

### Verificar que el componente existe:
```bash
php artisan tinker --execute="echo class_exists('App\\Livewire\\Clients\\ClientForm') ? 'OK' : 'ERROR';"
```

### Limpiar todo:
```bash
php artisan optimize:clear
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### Ver logs en tiempo real:
```bash
tail -f storage/logs/laravel.log
```

---

## Prueba Manual

### Datos de Prueba para Paso 1:

```
Tipo de Documento: CC
Número de Documento: 1234567890
Primer Nombre: Juan
Segundo Nombre: (opcional)
Primer Apellido: Pérez
Segundo Apellido: (opcional)
Fecha de Nacimiento: 1990-01-15
Lugar de Nacimiento: Bogotá
Género: M
Estado Civil: soltero
Nivel Educativo: profesional
Personas a Cargo: 0
```

Después de completar estos campos, el botón "Siguiente" debería funcionar.

---

## Verificación Rápida en el Navegador

Abre la consola del navegador y ejecuta:

```javascript
// Verificar si Livewire está cargado
console.log(typeof Livewire !== 'undefined' ? 'Livewire OK' : 'Livewire NO CARGADO');

// Verificar si Alpine está cargado
console.log(typeof Alpine !== 'undefined' ? 'Alpine OK' : 'Alpine NO CARGADO');

// Ver componentes Livewire en la página
console.log(Livewire.all());
```

---

## Si Nada Funciona

### Opción 1: Reiniciar todo
```bash
# Detener servidor
Ctrl+C

# Limpiar todo
php artisan optimize:clear

# Reiniciar servidor
php artisan serve
```

### Opción 2: Verificar permisos
```bash
# Dar permisos a storage y bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### Opción 3: Revisar logs
```bash
# Ver últimas líneas del log
tail -n 50 storage/logs/laravel.log
```

---

## Contacto de Soporte

Si el problema persiste, proporciona:
1. Captura de pantalla de la consola del navegador
2. Captura de pantalla de la pestaña Network
3. Últimas líneas del archivo `storage/logs/laravel.log`
4. Versión de PHP: `php -v`
5. Versión de Laravel: `php artisan --version`
