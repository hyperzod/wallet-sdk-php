<?php

namespace Hyperzod\WalletSdkPhp\Service;

/**
 * Service factory class for API resources in the root namespace.
 *
 * @property WalletService $walletService
 */
class CoreServiceFactory extends AbstractServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static $classMap = [
        'wallet' => WalletService::class,
    ];

    protected function getServiceClass($name)
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }
}
