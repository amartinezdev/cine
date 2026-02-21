<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/

if (file_exists($maintenance = __DIR__.'/../../laravel_apps/cine/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Este index.php sustituye al public/index.php estandar SOLO en el
| despliegue (lo copia el workflow de GitHub Actions). Estructura real
| en cPanel:
|
|   /home/alvaroma/laravel_apps/cine/   <- esta app
|   /home/alvaroma/public_html/cine/    <- este archivo vive aqui
|
*/

require __DIR__.'/../../laravel_apps/cine/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../../laravel_apps/cine/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
