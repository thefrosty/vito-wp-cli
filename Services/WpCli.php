<?php

declare(strict_types=1);

namespace App\Vito\Plugins\TheFrosty\VitoWpCli\Services;

use App\Exceptions\SSHError;
use App\Services\AbstractService;
use Closure;
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

    public function creationRules(array $input): array
    {
        return [
            'type' => [
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->service->server->services()->where('name', self::id())->exists()) {
                        $fail('WP-CLI is already installed on this server.');
                    }
                },
            ],
        ];
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
        $this->service->server->os()->cleanup();
    }

    /**
     * @throws SSHError
     */
    public function version(): string
    {
        return trim($this->service->server->ssh()->exec('wp cli version'));
    }
}
