# Almacén Ropa 2

Aplicación Laravel para la gestión de una tienda de ropa pequeña. Contiene panel de administración y tienda pública con funcionalidades básicas de catálogo, carrito, pedidos y pagos.

## Funcionalidades principales

- Panel de administración (CRUD completo) para gestionar:
  - Productos (nombre, descripción, precio, stock, categoría, imagen)
  - Categorías
  - Pedidos (ver, actualizar estado, historial)
  - Pagos (registro y gestión de pagos asociados a pedidos)
  - Usuarios/Clientes (gestión de cuentas y roles)
- Tienda pública:
  - Listado y búsqueda de productos
  - Ficha de producto con galería y stock
  - Carrito de compras (session-based)
  - Checkout que crea `Pedido` y `DetallePedido` y disminuye stock
  - Vista "Mis pedidos" para clientes con detalle y posibilidad de subir comprobante/pago
- Seguridad mínima:
  - Autenticación básica (login/logout)
  - Middleware `EnsureAdmin` para proteger rutas administrativas
- Migraciones y seeders para poblar datos iniciales (admin, clientes, productos de ejemplo)

## Contrato de datos (resumen de modelos y tablas)

- Producto (`MV_productos`)
  - id_producto (PK), nombre, descripcion, precio, stock, id_categoria, imagen
- Categoria (`MV_categorias`)
  - id_categoria (PK), nombre_categoria
- Pedido (`MV_pedidos`)
  - id_pedido (PK), id_usuario, total, estado, canal, fecha_pedido
- DetallePedido (`MV_detalle_pedidos`)
  - id_detalle (PK), id_pedido (FK), id_producto (FK), cantidad, precio_unitario
- Pago (`MV_pagos`)
  - id_pago (PK), id_pedido (FK), metodo, monto, fecha_pago
- Usuario/Cliente (`MV_usuarios`)
  - id_usuario (PK), nombre, email, password, rol

## Endpoints / Rutas principales

- Rutas públicas
  - GET `/` → listado de productos (ShopController@index)
  - GET `/product/{id}` → detalle de producto (ShopController@show)
  - POST `/cart/add` → añadir al carrito
  - GET `/cart` → ver carrito
  - POST `/checkout` → crear pedido
  - GET `/my-orders` → listar pedidos del cliente
  - GET `/order/{id}` → ver detalle de pedido público
  - POST `/pagos/public` → registrar pago desde la vista pública

- Rutas administrativas (protegidas por middleware)
  - Resource `productos`, `categorias`, `pedidos`, `pagos` — CRUD completo (controllers en `app/Http/Controllers`)

## CRUD por entidad (resumen)

- Productos (CRUD completo)
  - Crear: formulario en `productos/create.blade.php` → `ProductoController@store`
  - Leer: listado en `productos/index.blade.php` → `ProductoController@index`
  - Actualizar: `productos/edit.blade.php` → `ProductoController@update`
  - Borrar: `ProductoController@destroy` (usa transacciones y borra dependencias correctamente)

- Categorías (CRUD completo)
  - Archivo: `Categorias/*` y `CategoriaController`

- Pedidos
  - Listar/ver (admin): `PedidoController@index` / `show`
  - Estado: `PedidoController@update` (cambiar estado a Pagado/Entregado/Cancelado)
  - Eliminar: restaura stock y elimina detalle/pagos relacionados

- Pagos
  - Registrar pago (admin o cliente): `PagoController@store` / `PagosController@storePublic`
  - Listado: `pagos/index.blade.php`

## Cómo ejecutar localmente (resumen rápido)

1. Clona el repositorio
   git clone https://github.com/mariaverano/almacen_ropa2.git
2. Instala dependencias
   composer install
   npm install && npm run build
3. Configura `.env` (BD MySQL, APP_URL, etc.)
4. Ejecuta migraciones y seeders
   php artisan migrate --seed
5. Levanta servidor local (XAMPP o php artisan serve)

## Notas

- El proyecto mapea tablas con prefijo `MV_` en la base de datos; revisa las migraciones en `database/migrations`.
- Si necesitas que divida el commit único en una historia con commits semánticos, puedo crear `main-split-history` y empujarla.

