<?php

declare(strict_types=1);

namespace App\Application\Settings;

class ApplicationEnvironment
{
    public function __invoke()
    {
        return ($_ENV['APP_ENV'])??'dev';
    }
}
