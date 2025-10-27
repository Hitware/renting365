# 🚀 Inicio Rápido - Renting365

## ⚡ Pasos para Empezar

### 1. Iniciar el Servidor
```bash
cd /Users/Sites/renting365
php artisan serve
```

### 2. Abrir en el Navegador
```
http://localhost:8000
```

### 3. Iniciar Sesión

#### Opción 1: Analista de Crédito (Recomendado)
```
Email: analista@renting365.com
Password: password
```

#### Opción 2: Administrador
```
Email: admin@renting365.co
Password: Admin123!
```

#### Opción 3: Asesor Comercial
```
Email: asesor@renting365.com
Password: password
```

---

## 🎯 Qué Hacer Primero

### 1. Ver Listado de Clientes
- Ir a: **Dashboard → Gestión de Clientes**
- O directamente: `http://localhost:8000/clients`
- Verás 4 clientes de prueba con diferentes estados

### 2. Ver Detalle de un Cliente
- Click en **"Ver"** en cualquier cliente
- Explora los 6 tabs:
  - 📝 Personal
  - 💼 Laboral
  - 💰 Financiero
  - 📞 Referencias
  - 💳 Créditos
  - 📄 Documentos

### 3. Crear un Nuevo Cliente
- Click en **"+ Nuevo Cliente"**
- Completa el formulario de 6 pasos
- Observa el indicador de progreso
- Registra el cliente

### 4. Revisar Documentos (NUEVO)
- Ve al detalle de un cliente
- Tab **"Documentos"**
- Si hay documentos, click en **"Revisar"**
- Selecciona: Aprobar / Rechazar / Solicitar Nueva
- Agrega comentarios
- Guarda la revisión

---

## 📊 Datos de Prueba Disponibles

### Clientes Creados:
1. **Cliente Aprobado** (Score: 780)
2. **Cliente En Revisión** (Score: 650)
3. **Cliente Registro Inicial** (Sin score)
4. **Cliente Rechazado** (Score: 520)

Cada cliente tiene:
- ✅ Datos personales completos
- ✅ Contacto (dirección, teléfono, email)
- ✅ Empleo actual
- ✅ Información financiera
- ✅ 2 referencias
- ✅ Consulta Midatacrédito (cuando aplica)

---

## 🔍 Funcionalidades para Probar

### En el Listado:
- ✅ Buscar por documento o nombre
- ✅ Filtrar por estado
- ✅ Filtrar por score crediticio
- ✅ Filtrar por analista
- ✅ Ordenar por columnas (click en encabezados)
- ✅ Ver estadísticas en tiempo real

### En el Formulario:
- ✅ Validación en tiempo real
- ✅ Navegación entre pasos
- ✅ Indicador de progreso
- ✅ Mensajes de error claros
- ✅ Campos obligatorios marcados con *

### En la Vista Detallada:
- ✅ Navegación por tabs
- ✅ Información organizada
- ✅ Indicadores visuales de estado
- ✅ Badges de colores
- ✅ Datos financieros con gráficos

### En Documentos:
- ✅ Cargar archivos (PDF, JPG, PNG)
- ✅ Ver estado de cada documento
- ✅ Revisar documentos (modal)
- ✅ Aprobar/Rechazar con comentarios
- ✅ Versionamiento automático

---

## 🎨 Características Visuales

### Colores de Estado:
- 🟢 **Verde:** Aprobado
- 🟡 **Amarillo:** En Revisión / Pendiente
- 🔴 **Rojo:** Rechazado
- 🔵 **Azul:** Registro Inicial
- ⚪ **Gris:** Sin asignar

### Iconos:
- 👥 Total de clientes
- ⏰ En revisión
- ✅ Aprobados
- ❌ Rechazados

---

## 💡 Tips de Uso

### Para Asesores:
1. Crear clientes nuevos
2. Cargar documentos iniciales
3. Hacer seguimiento del estado

### Para Analistas:
1. Revisar documentos cargados
2. Verificar información financiera
3. Consultar Midatacrédito
4. Aprobar o rechazar clientes

### Para Administradores:
1. Ver estadísticas generales
2. Gestionar usuarios
3. Supervisar todo el proceso

---

## 🔧 Comandos Útiles

### Si necesitas reiniciar datos:
```bash
php artisan migrate:fresh --seed
```

### Si hay problemas de caché:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Para compilar assets (si usas npm):
```bash
npm run dev
```

---

## 📱 Responsive Design

El sistema funciona en:
- ✅ Desktop (1920x1080)
- ✅ Laptop (1366x768)
- ✅ Tablet (768x1024)
- ✅ Mobile (375x667)

---

## 🎯 Flujo Recomendado de Prueba

### 1. Login como Asesor
```
asesor@renting365.com / password
```

### 2. Crear Cliente
- Ir a `/clients/create`
- Completar 6 pasos
- Registrar

### 3. Login como Analista
```
analista@renting365.com / password
```

### 4. Revisar Cliente
- Ir a `/clients`
- Ver cliente creado
- Revisar información
- Aprobar/Rechazar

---

## 📚 Documentación Adicional

- **Técnica:** `MODULO_HOJA_VIDA_IMPLEMENTACION.md`
- **Acceso:** `INSTRUCCIONES_ACCESO.md`
- **Resumen:** `RESUMEN_IMPLEMENTACION_FINAL.md`

---

## ✨ ¡Listo!

El sistema está completamente funcional y listo para usar.

**¿Problemas?**
- Revisa `storage/logs/laravel.log`
- Verifica que el servidor esté corriendo
- Asegúrate de tener la base de datos configurada

**¡Disfruta explorando Renting365!** 🎉
