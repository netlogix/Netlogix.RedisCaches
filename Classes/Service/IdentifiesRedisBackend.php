<?php
declare(strict_types=1);

namespace Netlogix\RedisCaches\Service;

interface IdentifiesRedisBackend
{

    public function isRedisBackend(string $className): bool;

}
