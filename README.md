# DEPRECATION NOTICE
This package is no longer maintained. There is no replacement.

You can use a combination of the new `cache:list` Flow command and grep to achieve a similar result:
```bash
./flow cache:list | grep 'RedisBackend' | awk '{ print $2 }' | xargs -n 1 ./flow flow:cache:flushone
```

# Netlogix.RedisCaches
Flow CLI to flush all caches that use a RedisBackend.
