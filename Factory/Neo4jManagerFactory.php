<?php

namespace GensDeConfiance\Neo4jOGMManagerBundle\Factory;

use GraphAware\Bolt\Driver as BoltDriver;
use GraphAware\Neo4j\OGM\EntityManager;

class Neo4jManagerFactory
{
    const BOLT_PROTOCOL = 'bolt';

    const HTTP_PROTOCOL = 'http';

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param int    $httpPort
     * @param int    $boltPort
     *
     * @return EntityManager
     */
    public function createEntityManager(
        string $host = 'localhost',
        string $user = 'neo4j',
        string $password = 'neo4j',
        int $httpPort = 7474,
        int $boltPort = BoltDriver::DEFAULT_TCP_PORT,
        string $protocol = self::BOLT_PROTOCOL,
        string $cacheDir = null
    ): EntityManager {
        $dsn = sprintf(
            '%s://%s:%s@%s:%d',
            function_exists('bcmod') && $protocol === self::BOLT_PROTOCOL ? self::BOLT_PROTOCOL : self::HTTP_PROTOCOL,
            $user,
            $password,
            $host,
            function_exists('bcmod') && $protocol === self::BOLT_PROTOCOL ? $boltPort : $httpPort
        );

        return EntityManager::create($dsn, $cacheDir);
    }
}
