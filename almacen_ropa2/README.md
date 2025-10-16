# Almacén Ropa 2

Pequeña tienda desarrollada en Laravel para gestionar productos, categorías, pedidos y pagos.

Este repositorio contiene la aplicación usada para un proyecto local con XAMPP. Incluye un panel de administración y una tienda pública básica.

## Contenido

- `app/` - modelos, controladores y lógica de la aplicación.
- `resources/views/` - vistas Blade para admin y tienda pública.
- `database/migrations/` - migraciones (MV_ prefijo en tablas).
- `database/seeders/` - seeders (admin y cliente de ejemplo).

## Requisitos

- PHP 8.x (según tu entorno XAMPP)
- Composer
- MySQL
- Node.js + npm (opcional, para assets con Vite)

## Instalación rápida (local)

1. Clona el repositorio y entra en la carpeta del proyecto.
2. Copia el .env y ajusta credenciales DB:

```powershell
copy .env.example .env
```

3. Instala dependencias PHP:

```powershell
composer install
```

4. Genera la clave de la aplicación:

```powershell
php artisan key:generate
```

5. Configura la base de datos en `.env` y ejecuta migraciones + seeders:

```powershell
php artisan migrate
php artisan db:seed
```

6. Crea el enlace de almacenamiento (para imágenes):

```powershell
php artisan storage:link
```

7. Levanta el servidor local (opcional):

```powershell
php artisan serve
```

Accede por default en `http://127.0.0.1:8000` o mediante tu virtualhost en XAMPP.

## Credenciales de prueba

- Admin (si fue creado por el seeder):
  - email: `admin@example.com`
  - password: `Admin1234`

- Cliente de ejemplo:
  - email: `cliente@example.com`
  - password: `Cliente1234`

Si no existen, ejecuta `php artisan db:seed --class=CustomerSeeder` o revisa `database/seeders`.

## Flujo principal

- Panel admin: gestión de productos, categorías, pedidos y pagos.
- Tienda pública: listado de productos, carrito en sesión, checkout que crea `MV_pedidos` y `MV_detalle_pedidos`.
- Confirmación de pedido: `/order/{id}` — los clientes autenticados pueden registrar pagos.

## Notas importantes

- Las tablas principales usan prefijo `MV_` (por compatibilidad con la DB existente). Revisa modelos en `app/Models` para detalles.
- Las imágenes de productos pueden ser URLs externas o archivos en `storage/app/public/products`.
- Para permitir ver/confirmar pedidos sin login, se puede añadir un `access_token` al pedido (opcional).

## Ejecutar tests

Si tienes Pest/PHPUnit instalado en el proyecto:

```powershell
php artisan test
# o
vendor\bin\pest
```

## Contribuir

Lee `CONTRIBUTING.md` para pautas de commits y estilo de ramas.

---
Generado: 2025-10-12
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
