<?php
namespace Netlogix\RedisCaches\Command;

/*
 * This file is part of the Netlogix.RedisCaches package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cache\CacheManager;
use Neos\Flow\Cli\CommandController;

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
	 * @param bool $verbose
	 * @throws \Neos\Cache\Exception\NoSuchCacheException
	 */
	public function flushCommand($verbose = false)
	{
		if (!class_exists('Neos\Cache\Backend\RedisBackend')) {
			$this->outputLine('The class "\Neos\Cache\Backend\RedisBackend" does not exist!');
			$this->sendAndExit(1);
		}

		foreach ($this->cacheManager->getCacheConfigurations() as $cacheIdentifier => $cacheConfiguration) {
			if (!isset($cacheConfiguration['backend'])) {
				// Cache doesn't have a backend configured, so FileBackend is used
				continue;
			}

			if (is_a($cacheConfiguration['backend'], \Neos\Cache\Backend\RedisBackend::class, true)) {
				$cache = $this->cacheManager->getCache($cacheIdentifier);
				if ($verbose) {
					$this->outputLine('Flushing Redis Cache %s', [$cacheIdentifier]);
				}
				$cache->flush();
			}
		}
	}

}
