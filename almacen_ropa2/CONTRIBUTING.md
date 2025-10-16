# Contribuir y convención de commits

Gracias por contribuir. Aquí están las pautas mínimas para mantener el historial de commits claro y fácil de seguir.

## Flujo de trabajo recomendado

- Usa ramas feature para cambios: `feature/<descripción-corta>`
- Para correcciones rápidas: `fix/<descripción-corta>`
- Para cambios de refactor o estilo: `refactor/<descripción-corta>`
- Haz pull request hacia `main` y añade una descripción clara.

## Convención de commits (basado en Conventional Commits)

Formato: `<type>(<scope>): <short summary>`

Types comunes:
- feat: nueva funcionalidad
- fix: corrección de bug
- docs: cambios en documentación
- style: cambios que no afectan la lógica (format)
- refactor: refactorización de código
- test: añadir o arreglar tests
- chore: tareas de mantenimiento (actualizar dependencias, config)

Ejemplos:

```
feat(pedidos): añadir vista 'Mis pedidos' para clientes
fix(pagos): corregir redirección después de registrar pago
docs(readme): añadir instrucciones de instalación
```

## Mensajes de PR

- Explica el porqué del cambio, no solo el qué.
- Si el PR arregla un issue, referencia `#<numero>`.

## Estándares de código

- Mantén la indentación y estilo del proyecto.
- Añade tests para cambios funcionales importantes.

## Revisión antes de merge

- Ejecuta `composer install` y `php artisan test` localmente.
- Asegúrate de que no hay errores de sintaxis (`php -l`).
