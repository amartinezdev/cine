# Cine

Aplicación web para la gestión de la cartelera de un cine, construida con Laravel. Incluye un catálogo público de películas con búsqueda y filtros, un panel de administración para gestionar géneros, películas y promociones, subida de pósters, y notificaciones automáticas por Telegram cuando se publica una nueva promoción.

## Funcionalidades

- **Catálogo público**: listado de películas con búsqueda por título y filtro por género, y una ficha de detalle para cada película.
- **Gestión de películas y géneros**: CRUD completo desde el panel de administración, con subida de imágenes (pósters) gestionada con [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary).
- **Promociones**: creación de promociones con fecha de inicio/fin, mostradas como banner en la web mientras están activas. Al crear una promoción se envía automáticamente un aviso a un canal/chat de Telegram.
- **Desactivación automática de promociones**: un comando Artisan programado revisa y desactiva las promociones cuya fecha de fin ya ha pasado.
- **Panel de administración con roles**: acceso restringido mediante middleware, separando usuarios normales de administradores.
- **Autenticación completa**: registro, login, verificación de email, recuperación y confirmación de contraseña, y edición de perfil (basado en Laravel Breeze).

## Stack

- **Backend**: Laravel 9, PHP 8
- **Frontend**: Blade, Tailwind CSS, Vite
- **Base de datos**: MySQL / MariaDB (compatible con cualquier motor soportado por Laravel)
- **Imágenes**: Spatie Media Library
- **Notificaciones**: Telegram Bot API (`irazasyed/telegram-bot-sdk`)
- **Testing**: PHPUnit

## Instalación

### Requisitos

- PHP 8.x
- Composer
- Node.js + npm
- Una base de datos (MySQL, MariaDB, PostgreSQL o SQLite)

### Pasos

1. Clonar el repositorio e instalar las dependencias:

   ```bash
   composer install
   npm install
   ```

2. Crear el archivo de entorno y la clave de la aplicación:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configurar la conexión a la base de datos en `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=cine
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. (Opcional) Configurar las notificaciones de Telegram en `.env`:

   ```env
   TELEGRAM_BOT_TOKEN=tu_token_de_bot
   TELEGRAM_CHAT_ID=tu_chat_id
   ```

5. Ejecutar las migraciones y los seeders (crea usuarios, géneros y varias películas de ejemplo con póster incluido):

   ```bash
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```

6. Compilar los assets:

   ```bash
   npm run dev    # entorno de desarrollo
   npm run build  # producción
   ```

7. Levantar el servidor:

   ```bash
   php artisan serve
   ```

   La aplicación estará disponible en `http://127.0.0.1:8000`.

### Tarea programada

La desactivación automática de promociones caducadas se ejecuta mediante el scheduler de Laravel. En desarrollo puede lanzarse con:

```bash
php artisan schedule:work
```

En producción, basta con añadir la siguiente entrada al cron del servidor:

```bash
* * * * * php /ruta/al/proyecto/artisan schedule:run >> /dev/null 2>&1
```

### Usuarios de prueba

El seeder crea un usuario administrador y varios usuarios normales (contraseña `1` para todos):

| Rol           | Email             |
| ------------- | ----------------- |
| Administrador | `1@gmail.com`      |
| Usuario       | `alvaro@gmail.com` |

## Estructura del proyecto

```
app/
├── Console/Commands/     # Comando para desactivar promociones caducadas
├── Http/Controllers/     # Controladores públicos y de administración
│   └── Admin/            # CRUD de géneros, películas y promociones
├── Models/                # genero, pelicula, Promocion, User
resources/views/
├── admin/                 # Panel de administración
├── auth/                  # Vistas de autenticación
└── peliculas/              # Catálogo público
database/
├── migrations/
└── seeders/                # Datos de ejemplo (géneros, películas y pósters)
```

## Autor

**Álvaro Martínez** — [@amartinezdev](https://github.com/amartinezdev)
