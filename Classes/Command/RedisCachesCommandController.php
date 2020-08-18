<?php
namespace Netlogix\RedisCaches\Command;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cache\CacheManager;
use Neos\Flow\Cli\CommandController;
use Netlogix\RedisCaches\Service\IdentifiesRedisBackend;

/**
 * @Flow\Scope("singleton")
 */
class RedisCachesCommandController extends CommandController
{

	/**
	 * @Flow\Inject
	 * @var CacheManager
	 */
	protected $cacheManager;

	/**
	 * @Flow\Inject
	 * @var IdentifiesRedisBackend
	 */
	protected $identifiesRedisBackend;

    /**
     * @param bool $verbose
     * @throws \Neos\Cache\Exception\NoSuchCacheException
     */
	public function flushCommand(bool $verbose = false): void
	{
		foreach ($this->cacheManager->getCacheConfigurations() as $cacheIdentifier => $cacheConfiguration) {
			if (!isset($cacheConfiguration['backend'])) {
				// Cache doesn't have a backend configured, so FileBackend is used
				continue;
			}

			if ($this->identifiesRedisBackend->isRedisBackend($cacheConfiguration['backend'])) {
				$cache = $this->cacheManager->getCache($cacheIdentifier);
				if ($verbose) {
					$this->outputLine('Flushing Redis Cache %s', [$cacheIdentifier]);
				}
				$cache->flush();
			}
		}
	}

}
