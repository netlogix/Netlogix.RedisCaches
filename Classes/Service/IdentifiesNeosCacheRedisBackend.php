<?php
declare(strict_types=1);

namespace Netlogix\RedisCaches\Service;

use Neos\Cache\Backend\RedisBackend;
use Neos\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class IdentifiesNeosCacheRedisBackend implements IdentifiesRedisBackend
{

    public function isRedisBackend(string $className): bool
    {
        if (!class_exists(RedisBackend::class)) {
            return false;
        }

        return is_a($className, RedisBackend::class, true);
    }

}
