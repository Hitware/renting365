# Configuración de Amazon Bedrock para Renting365

## ¿Qué es Amazon Bedrock?

Amazon Bedrock es el servicio de AWS para usar modelos de IA generativa como Claude de Anthropic. Es más moderno y potente que Lex.

## Paso 1: Habilitar Amazon Bedrock

1. Ir a AWS Console: https://console.aws.amazon.com/bedrock/
2. Seleccionar región: **us-east-1** (N. Virginia)
3. En el menú lateral, ir a "Model access"
4. Click en "Manage model access"
5. Seleccionar: **Anthropic Claude 3 Haiku**
6. Click en "Request model access"
7. Esperar aprobación (usualmente instantánea)

## Paso 2: Crear Usuario IAM

1. Ir a IAM Console: https://console.aws.amazon.com/iam/
2. Click en "Users" → "Create user"
3. Nombre: `renting365-bedrock-user`
4. Click "Next"

## Paso 3: Crear Política IAM

Crear una política con estos permisos:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "bedrock:InvokeModel",
                "bedrock:InvokeModelWithResponseStream"
            ],
            "Resource": [
                "arn:aws:bedrock:us-east-1::foundation-model/anthropic.claude-3-haiku-20240307-v1:0"
            ]
        }
    ]
}
```

Nombre de la política: `Renting365BedrockPolicy`

## Paso 4: Asignar Política al Usuario

1. Seleccionar el usuario creado
2. Click en "Add permissions" → "Attach policies directly"
3. Buscar y seleccionar `Renting365BedrockPolicy`
4. Click "Next" → "Add permissions"

## Paso 5: Crear Access Keys

1. Seleccionar el usuario
2. Ir a "Security credentials"
3. Click en "Create access key"
4. Seleccionar "Application running outside AWS"
5. Click "Next" → "Create access key"
6. **GUARDAR** Access Key ID y Secret Access Key

## Paso 6: Configurar .env

Agregar al archivo `.env`:

```env
AWS_ACCESS_KEY_ID=tu_access_key_aqui
AWS_SECRET_ACCESS_KEY=tu_secret_key_aqui
AWS_DEFAULT_REGION=us-east-1
```

## Paso 7: Probar el Chatbot

1. Ejecutar: `php artisan serve`
2. Abrir: http://localhost:8000
3. Click en el botón naranja del chatbot
4. Escribir: "Hola, quiero información sobre los planes"

## Características del Chatbot

✅ **IA Generativa con Claude 3 Haiku**
- Respuestas naturales y contextuales
- Entiende preguntas complejas
- Conversaciones fluidas

✅ **Conocimiento Completo**
- Todos los planes y precios
- Requisitos y documentos
- Motos disponibles
- Beneficios incluidos
- Proceso de solicitud
- Cobertura geográfica

✅ **Fallback Inteligente**
- Si AWS falla, usa respuestas predefinidas
- Siempre responde al usuario
- Sin interrupciones del servicio

## Costos Estimados

**Claude 3 Haiku:**
- Input: $0.00025 por 1K tokens
- Output: $0.00125 por 1K tokens

**Ejemplo:**
- 1000 conversaciones/mes
- ~500 tokens por conversación
- Costo: ~$0.75/mes

¡Muy económico! 💰

## Ventajas vs Lex

| Característica | Bedrock (Claude) | Lex |
|---------------|------------------|-----|
| IA Generativa | ✅ Sí | ❌ No |
| Respuestas naturales | ✅ Excelente | ⚠️ Limitado |
| Configuración | ✅ Simple | ⚠️ Compleja |
| Costo | ✅ Muy bajo | ⚠️ Más alto |
| Mantenimiento | ✅ Mínimo | ⚠️ Requiere intents |

## Solución de Problemas

### Error: "Access Denied"
- Verificar que el modelo esté habilitado en Bedrock
- Revisar permisos IAM
- Confirmar región us-east-1

### Error: "Model not found"
- Esperar aprobación del modelo
- Verificar nombre del modelo en el código

### Chatbot no responde
- Revisar logs: `tail -f storage/logs/laravel.log`
- Verificar credenciales AWS en .env
- Probar conexión: `php artisan tinker` → `config('services.aws.key')`

## Soporte

Documentación oficial:
- https://docs.aws.amazon.com/bedrock/
- https://docs.anthropic.com/claude/docs
