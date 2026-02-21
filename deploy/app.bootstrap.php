<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Ruta publica en el hosting (cPanel)
|--------------------------------------------------------------------------
|
| En este despliegue, la carpeta "public" de Laravel NO es el document
| root. La estructura real en cPanel es:
|
|   /home/alvaroma/laravel_apps/cine/   <- esta app (APP_ROOT)
|   /home/alvaroma/public_html/cine/    <- document root real
|
| Le decimos a Laravel donde esta esa carpeta publica de verdad para que
| asset(), storage:link, etc. apunten al sitio correcto.
|
| Este archivo sustituye a bootstrap/app.php SOLO en el despliegue (lo
| copia el workflow de GitHub Actions); en local se sigue usando el
| bootstrap/app.php estandar del repositorio.
|
| Nota: usamos el binding 'path.public' directamente en vez del metodo
| usePublicPath() porque esta version de Laravel 9 (9.x-dev, anterior a
| la 9.37) no lo tiene todavia. public_path() internamente resuelve este
| binding, asi que el efecto es el mismo.
|
*/

$app->instance('path.public', dirname(__DIR__) . '/../../public_html/cine');

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
