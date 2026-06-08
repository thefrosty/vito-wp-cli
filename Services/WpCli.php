<?php

declare(strict_types=1);

namespace App\Vito\Plugins\TheFrosty\VitoWpCli\Services;

use App\Exceptions\SSHError;
use App\Services\AbstractService;
use function event;
use function trim;
use function view;

/**
 * Class WpCli
 * @package App\Vito\Plugins\TheFrosty\VitoWpCli\Services
 */
class WpCli extends AbstractService
{

    public static function id(): string
    {
        return 'wp-cli';
    }

    public static function type(): string
    {
        return 'wp-cli';
    }

    public function unit(): string
    {
        return 'wp-cli';
    }

    /**
     * @throws SSHError
     */
    public function install(): void
    {
        $this->service->server->ssh()->exec(
            view(self::id() . '::install'),
            'install-wp-cli'
        );
        event('service.installed', $this->service);
        $this->service->server->os()->cleanup();
    }

    /**
     * @throws SSHError
     */
    public function uninstall(): void
    {
        $this->service->server->ssh()->exec(
            view(self::id() . '::uninstall'),
            'uninstall-wp-cli'
        );
        event('service.uninstalled', $this->service);
    }

    /**
     * @throws SSHError
     */
    public function version(): string
    {
        return trim($this->service->server->ssh()->exec('wp cli version'));
    }
}
