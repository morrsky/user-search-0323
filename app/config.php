<?php

declare(strict_types=1);

use App\Application\Settings\ApplicationEnvironment;
use App\Application\Settings\SettingsInterface;
use App\Infrastructure\Adapter\AdapterInterface;
use App\Infrastructure\Adapter\Database\DatabaseAdapterInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment as TwigRenderer;
use Twig\Loader\FilesystemLoader;
use function DI\get;

return [
    // Load application settings
    SettingsInterface::class => function () {
        return require APP_ROOT_DIRPATH . '/app/settings.php';
    },
    // Configure Twig
    TwigRenderer::class => function () {
        $loader = new FilesystemLoader(APP_ROOT_DIRPATH . '/view');

        return new TwigRenderer($loader);
    },
    // Set datasource adapter
    AdapterInterface::class => get(DatabaseAdapterInterface::class),
    \App\Infrastructure\Respository\RepositoryInterface::class => get(\App\Infrastructure\Respository\DatabaseRepositoryAbstract::class),
    // Set Database adapter
    DatabaseAdapterInterface::class => function(ContainerInterface $c) {
        // returns database wrapper depending on adapter driver value. It may be 'pdo', 'docrtine', 'eloquent' etc.
        $appEnv = $c->get(ApplicationEnvironment::class)();
        $dbSettings = $c->get(SettingsInterface::class)->get('database');
        $driver = explode("_",$dbSettings[$appEnv]['driver']);

        $adapter = $c->get(sprintf("App\Infrastructure\Adapter\Database\%sAdapter",ucfirst($driver[0])));
        $adapter->connect($dbSettings[$appEnv],$driver[1]);

        return $adapter;
    }
];
