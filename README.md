# Funkystep (Laravel)

## Requisitos
- PHP 8.x, Composer, Node.js, MySQL, Git

## Setup local
1. `cp .env.example .env`  (o crea .env manualmente)
2. `composer install`
3. `php artisan key:generate`
4. Configura DB en `.env`
5. `php artisan migrate --seed` (si aplica)
6. `php artisan storage:link`
7. `npm install && npm run dev` (o `build`)

## Flujo de ramas
- `main`: estable (protegida)
- `develop`: integración
- feature branches: `feature/nombre-corto`
