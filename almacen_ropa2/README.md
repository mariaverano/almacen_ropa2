Almacén Ropa 2  Panel y CRUD explicado (versión clara)

Resumen rápido

Almacén Ropa 2 es una pequeña tienda online con dos áreas principales: la tienda pública (catálogo, carrito, checkout) y el panel de administración donde el personal puede gestionar productos, categorías, pedidos y pagos.

Credenciales demo

- Administrador
  - Email: admin@example.com
  - Contraseña: Admin1234

- Usuario de prueba
  - Email: user@example.com
  - Contraseña: User1234

Qué hace el administrador

El administrador accede al panel privado 

- Ver el dashboard  (pedidos recientes, ventas, productos bajos de stock).
- Gestionar Productos: crear nuevos productos, editar datos (nombre, descripción, precio, stock, categoría), subir imágenes y eliminar productos. El CRUD de productos incluye validaciones de stock y relación con categorías.
- Gestionar Categorías: crear/editar/borrar categorías. Cada producto pertenece a una categoría y la categoría se usa para filtrar el catálogo público.
- Gestionar Pedidos: ver la lista de pedidos recibidos, abrir el detalle de cada pedido (productos, cantidades, precios, total, datos del cliente), cambiar el estado del pedido (por ejemplo: Pendiente  Procesando  Enviado  Entregado  Cancelado) y anotar observaciones.
- Gestionar Pagos: registrar pagos manualmente (por ejemplo, cuando el cliente entrega un comprobante), asociar un pago a un pedido y marcar el pedido como pagado. También puede ver historial de pagos.

Detalle del CRUD por entidad

- Productos (ruta admin: `productos`)
  - Crear: formulario con campos: nombre, descripción, precio, stock, categoría, imagen(es). Al crear se valida que el precio y el stock sean números positivos.
  - Leer/Listar: tabla con columnas principales (imagen, nombre, categoría, precio, stock, acciones). La tabla permite búsqueda y paginación.
  - Actualizar: editar cualquiera de los campos; al actualizar la imagen anterior se reemplaza.
  - Borrar: elimina el producto. Antes de borrar se verifica/ajusta dependencias (por ejemplo, no eliminar si hay pedidos pendientes que lo referencien) y se ejecuta en una transacción para garantizar consistencia.

- Categorías (ruta admin: `categorias`)
  - Crear: nombre de categoría.
  - Leer/Listar: ver lista de categorías con contador de productos por categoría.
  - Actualizar: cambiar nombre.
  - Borrar: si tiene productos asociados, muestra advertencia o impide borrado (según la configuración).

- Pedidos (ruta admin: `pedidos`)
  - Listar: ver todos los pedidos con filtros por estado y fecha.
  - Detalle: dentro del pedido verás el listado de productos (cantidad, precio unitario), totales, datos del cliente y estado.
  - Cambiar estado: menú para actualizar el estado (Pendiente, Pagado, Enviado, Entregado, Cancelado).
  - Eliminar/Anular: si es necesario, el admin puede anular un pedido  la operación restaura stock y elimina registros relacionados (detalle de pedido y pagos) dentro de una transacción.

- Pagos (ruta admin: `pagos`)
  - Registrar pago: formulario para asociar un pago a un pedido (método, monto, fecha, nota/archivo opcional).
  - Listar: ver pagos filtrables por pedido o fecha.
  - Ver/Eliminar: ver comprobante y, si procede, eliminar un pago (esto puede afectar el estado del pedido).

Uso típico del flujo (ejemplo)

1. Cliente agrega productos al carrito y hace checkout.
2. Sistema crea un `Pedido` con uno o varios `DetallePedido` y disminuye el stock de los productos.
3. Cliente puede subir comprobante o pagar mediante el flujo público (según configuración).
4. El admin revisa pedidos en el panel, verifica el pago en `Pagos` y cambia el estado del pedido a `Pagado`  `Enviado`  `Entregado`.
5. Si el admin anula un pedido, el stock se restaura automáticamente.

Notas rápidas

- Las rutas administrativas están protegidas por autenticación y middleware de administrador.
- Revisa las migraciones en `database/migrations` para ver la estructura exacta de las tablas (`MV_productos`, `MV_categorias`, `MV_pedidos`, `MV_detalle_pedidos`, `MV_pagos`, `MV_usuarios`).

  Tecnologias usadas
  PHP 

Lenguaje del lado servidor que ejecuta toda la lógica de la aplicación (controladores, modelos, migraciones y comandos artisan).
Laravel (laravel/framework ^12)

Framework PHP MVC usado para routing, controladores, Eloquent (ORM), migraciones, middleware y la estructura general de la app (autenticación, validaciones, jobs, etc.).
MySQL

Base de datos relacional donde se almacenan productos, categorías, usuarios, pedidos, detalle de pedidos y pagos.
Composer

Gestor de dependencias PHP; se usa para instalar/actualizar paquetes de Laravel y configurar el autoload (comando típico: composer install).


Herramienta de desarrollo/bundling para los assets frontend (dev server rápido y vite build para producción). Integrada con Laravel mediante el plugin.
Tailwind CSS

Framework de utilidades CSS utilizado para los estilos de la interfaz en lugar de Bootstrap; permite componer diseño con clases utilitarias.

