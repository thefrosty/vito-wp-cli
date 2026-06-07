<?php

namespace App\Vito\Plugins\TheFrosty\VitoWpCli;

use App\Plugins\AbstractPlugin;
use App\Plugins\RegisterServiceType;
use App\Plugins\RegisterViews;
use App\Vito\Plugins\TheFrosty\VitoWpCli\Services\WpCli;

class Plugin extends AbstractPlugin
{
    protected string $name = 'WP CLI';

    protected string $description = 'A Vito plugin to install WP CLI';

    public function boot(): void
    {
        RegisterViews::make(WpCli::id())
            ->path(__DIR__ . '/views')
            ->register();

        RegisterServiceType::make(WpCli::id())
            ->type(WpCli::type())
            ->label('WP CLI')
            ->handler(WpCli::class)
            ->register();
    }
}
