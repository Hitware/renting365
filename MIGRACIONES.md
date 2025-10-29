# 🔧 Ejecutar Migraciones sin Terminal

## 📋 Instrucciones

Como no tienes acceso a terminal en tu hosting, puedes ejecutar las migraciones desde el navegador usando esta ruta especial.

### 🔐 Paso 1: Configurar la Clave de Seguridad

1. Abre tu archivo `.env`
2. Agrega esta línea (o modifícala si ya existe):
   ```
   MIGRATION_KEY=tu-clave-super-secreta-aqui-2024
   ```
3. **IMPORTANTE**: Cambia `tu-clave-super-secreta-aqui-2024` por una clave única y segura

### 🚀 Paso 2: Ejecutar las Migraciones

Visita esta URL en tu navegador (reemplaza los valores):

```
https://tu-dominio.com/run-migrations/tu-clave-super-secreta-aqui-2024
```

**Ejemplo:**
```
https://renting365.co/run-migrations/mi-clave-secreta-123
```

### ✅ Respuesta Exitosa

Si todo sale bien, verás algo como:
```json
{
  "success": true,
  "message": "Migraciones ejecutadas correctamente",
  "output": "Migration table created successfully..."
}
```

### ❌ Errores Comunes

**Error 403 - Acceso no autorizado:**
- La clave en la URL no coincide con la del archivo `.env`
- Verifica que hayas copiado la clave correctamente

**Error 500:**
- Puede haber un problema con la base de datos
- Verifica las credenciales de la base de datos en el `.env`

### 🔒 Seguridad

1. **NUNCA** compartas tu `MIGRATION_KEY` públicamente
2. Usa una clave larga y compleja (mínimo 20 caracteres)
3. Después de ejecutar las migraciones, puedes cambiar la clave
4. Esta ruta NO requiere autenticación, solo la clave secreta

### 📝 Ejemplo Completo

1. En tu `.env`:
   ```
   MIGRATION_KEY=R3nt1ng365$ecur3K3y!2024#Pr0d
   ```

2. En tu navegador:
   ```
   https://renting365.co/run-migrations/R3nt1ng365$ecur3K3y!2024#Pr0d
   ```

### 🎯 Comandos Disponibles

#### Ejecutar Migraciones
La ruta `/run-migrations/{clave}` ejecuta:
```bash
php artisan migrate --force
```
Esto ejecutará todas las migraciones pendientes en tu base de datos.

#### Ejecutar Seeders (Datos de Ejemplo)
La ruta `/run-seeders/{clave}` ejecuta:
```bash
php artisan db:seed --force
```

**Para ejecutar los seeders:**
```
https://tu-dominio.com/run-seeders/tu-clave-super-secreta-aqui-2024
```

**Ejemplo:**
```
https://renting365.co/run-seeders/R3nt1ng365$ecur3K3y!2024#Pr0d
```

**Esto creará:**
- ✅ Roles y permisos del sistema
- ✅ Usuarios de ejemplo (admin, asesores, clientes)
- ✅ Motocicletas de ejemplo
- ✅ Clientes de ejemplo
- ✅ Contratos de ejemplo
- ✅ Toda la data necesaria para probar la plataforma

**IMPORTANTE:** Solo ejecuta los seeders UNA VEZ después de las migraciones. Si los ejecutas múltiples veces, duplicará los datos.

### ⚠️ Notas Importantes

**Para Migraciones:**
- Solo ejecuta esta ruta cuando necesites aplicar nuevas migraciones
- La opción `--force` permite ejecutar migraciones en producción
- Asegúrate de tener un backup de tu base de datos antes de ejecutar
- Esta ruta está disponible en cualquier momento

**Para Seeders:**
- Ejecuta los seeders SOLO UNA VEZ después de las migraciones
- Los seeders crearán usuarios de prueba con contraseñas predefinidas
- Si ejecutas múltiples veces, se duplicarán los datos
- Ideal para ambientes de desarrollo y pruebas

### 🔑 Credenciales de Usuarios Creados

Después de ejecutar los seeders, podrás iniciar sesión con:

**Administrador:**
- Email: `admin@renting365.co`
- Password: `Admin123!`

**Asesor de Crédito:**
- Email: `asesor@renting365.co`
- Password: `Asesor123!`

**Cliente:**
- Email: `cliente@renting365.co`
- Password: `Cliente123!`

### 🆘 Soporte

Si tienes problemas:
1. Verifica que tu archivo `.env` esté configurado correctamente
2. Asegúrate de que la conexión a la base de datos funcione
3. Revisa los logs de Laravel en `storage/logs/laravel.log`
