# Configuración de Amazon Lex para Renting365

## 1. Crear Bot en Amazon Lex

### Paso 1: Acceder a AWS Console
1. Ir a https://console.aws.amazon.com/lexv2/
2. Seleccionar región (recomendado: us-east-1)
3. Click en "Create bot"

### Paso 2: Configuración Básica del Bot
```
Bot name: Renting365Assistant
Description: Asistente virtual para consultas sobre renting de motos
IAM role: Create a role with basic Amazon Lex permissions
COPPA: No
Idle session timeout: 5 minutes
```

### Paso 3: Configurar Idioma
```
Language: Spanish (ES)
Voice interaction: None (solo texto)
```

### Paso 4: Crear Intents (Intenciones)

#### Intent 1: ConsultarPlanes
**Utterances (frases de ejemplo):**
- Quiero conocer los planes
- Cuáles son los planes disponibles
- Qué planes tienen
- Información sobre planes
- Planes de renting

**Response:**
```
Tenemos 3 planes disponibles:
1. Plan Delivery ($350.000/mes) - Ideal para trabajadores de delivery
2. Plan Universitario ($280.000/mes) - Especial para estudiantes
3. Plan Emprendedor ($400.000/mes) - Para empresarios

Todos incluyen SOAT, seguro de vida, todo riesgo y mantenimiento. ¿Sobre cuál te gustaría más información?
```

#### Intent 2: ConsultarRequisitos
**Utterances:**
- Qué requisitos necesito
- Cuáles son los requisitos
- Qué documentos necesito
- Requisitos para rentar

**Response:**
```
Los requisitos son:
✓ Cédula de ciudadanía
✓ Licencia de conducción vigente
✓ Referencias personales
✓ Sin cuota inicial

¿Te gustaría iniciar el proceso de solicitud?
```

#### Intent 3: ConsultarMotos
**Utterances:**
- Qué motos tienen
- Modelos disponibles
- Cuáles son las motos
- Motos para rentar

**Response:**
```
Nuestras motos disponibles:
🏍️ Boxer 150 - Ideal para delivery
🏍️ Discover 125 - Perfecta para estudiantes
🏍️ Pulsar 180 - Para emprendedores

Todas con mantenimiento incluido y seguro completo. ¿Quieres ver la ficha técnica de alguna?
```

#### Intent 4: ConsultarCobertura
**Utterances:**
- Dónde están ubicados
- En qué ciudades operan
- Cobertura
- Ciudades disponibles

**Response:**
```
📍 Actualmente operamos en Cartagena
🔜 Próximamente en Barranquilla y Santa Marta

¿Estás en Cartagena y te gustaría solicitar información?
```

#### Intent 5: HablarConAsesor
**Utterances:**
- Quiero hablar con un asesor
- Contactar asesor
- Hablar con alguien
- Necesito ayuda personalizada

**Response:**
```
¡Claro! Puedes contactar a nuestros asesores:
📞 WhatsApp: +57 314 5144067
📧 Email: info@renting365.co

Horario: Lunes a Sábado 8am - 6pm
¿Te gustaría que te redirija a WhatsApp?
```

## 2. Configurar Variables de Entorno

Agregar al archivo `.env`:

```env
AWS_ACCESS_KEY_ID=tu_access_key
AWS_SECRET_ACCESS_KEY=tu_secret_key
AWS_DEFAULT_REGION=us-east-1

AWS_LEX_BOT_ID=tu_bot_id
AWS_LEX_BOT_ALIAS_ID=tu_alias_id
AWS_LEX_LOCALE_ID=es_ES
```

## 3. Obtener Bot ID y Alias ID

1. En la consola de Lex, selecciona tu bot
2. Ve a "Bot versions" → "Aliases"
3. Copia el Bot ID y Alias ID
4. Pégalos en el archivo .env

## 4. Configurar Permisos IAM

Crear política IAM con estos permisos:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "lex:RecognizeText",
                "lex:RecognizeUtterance"
            ],
            "Resource": "arn:aws:lex:us-east-1:*:bot-alias/*/*"
        }
    ]
}
```

## 5. Probar el Chatbot

1. Ejecutar: `php artisan serve`
2. Abrir: http://localhost:8000
3. Click en el botón del chatbot (círculo naranja)
4. Escribir: "Quiero conocer los planes"

## 6. Personalización Avanzada

### Agregar más intents según necesites:
- ConsultarPrecio
- AgendarCita
- EstadoSolicitud
- ConsultarMantenimiento

### Configurar Slots (parámetros):
Para capturar información específica como:
- Nombre del cliente
- Teléfono
- Ciudad
- Tipo de plan preferido

## Notas Importantes

- El chatbot funciona 24/7
- Respuestas en español
- Integrado con el diseño del sitio
- Sesiones únicas por usuario
- Logs de conversaciones en Laravel

## Soporte

Para más información sobre Amazon Lex:
https://docs.aws.amazon.com/lex/
