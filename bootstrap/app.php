<?php

require_once __DIR__ . '/../vendor/autoload.php';

$envFileName = '.env';

if (!isset($_SERVER['HTTP_HOST'])) {
    $envFileName = 'test.env';
}

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__), $envFileName
))->bootstrap();

/* Create The Application */
$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();
$app->withEloquent();
$app->configure('app');

/* Container Bindings */
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

//$app->singleton(
//    Illuminate\Contracts\Console\Kernel::class,
//    App\Console\Kernel::class
//);

$app->singleton(App\Services\GifSearch::class);

/* Register Middleware */
// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/* Register Service Providers */
// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

/* Load Routes */
$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
