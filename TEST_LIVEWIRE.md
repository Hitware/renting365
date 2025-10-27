# Test del Componente Livewire

## Pasos para Verificar

### 1. Abrir el Navegador en Modo Incógnito
Esto asegura que no haya caché del navegador interfiriendo.

### 2. Acceder a la URL
```
http://localhost:8000/clients/create
```

### 3. Abrir la Consola del Navegador (F12)
Ejecuta este código en la consola:

```javascript
// Verificar que Livewire está cargado
console.log('Livewire:', typeof Livewire);

// Ver todos los componentes Livewire
if (typeof Livewire !== 'undefined') {
    console.log('Componentes:', Livewire.all());
    
    // Ver el primer componente
    let component = Livewire.all()[0];
    console.log('Componente actual:', component);
    console.log('Paso actual:', component.get('currentStep'));
}
```

### 4. Completar el Formulario con Estos Datos EXACTOS

```
Tipo de Documento: CC
Número de Documento: 1234567890
Primer Nombre: Juan
Primer Apellido: Perez
Fecha de Nacimiento: 1990-01-15
Género: M
Estado Civil: soltero
Nivel Educativo: profesional
```

### 5. Hacer Click en "Siguiente"

Observa en la consola si:
- Aparece algún error
- Se hace una petición a `/livewire/update`
- El paso cambia de 1 a 2

### 6. Si No Funciona, Ejecuta en la Consola:

```javascript
// Forzar el cambio de paso manualmente
if (typeof Livewire !== 'undefined') {
    let component = Livewire.all()[0];
    component.call('nextStep');
}
```

## Resultado Esperado

Si todo funciona:
1. El botón muestra "Procesando..." brevemente
2. El formulario avanza al Paso 2
3. La barra de progreso se actualiza
4. No hay errores en la consola

## Si Aún No Funciona

Copia y pega el resultado de estos comandos:

```javascript
// En la consola del navegador
console.log('Livewire:', typeof Livewire);
console.log('Alpine:', typeof Alpine);
console.log('Componentes:', Livewire ? Livewire.all().length : 0);
```

Y también ejecuta en la terminal:

```bash
php artisan --version
php -v
```
