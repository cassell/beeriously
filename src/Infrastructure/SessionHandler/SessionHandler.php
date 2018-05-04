<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\SessionHandler;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class SessionHandler extends PdoSessionHandler
{
    public function __construct(PdoConnectionDsnProviderInterface $pdoConnectionDsnProvider)
    {
        // https://github.com/symfony/recipes/issues/206

        $pdoOrDsn = $pdoConnectionDsnProvider->getPdoDsn();

        $options = [
            'db_username' => $pdoConnectionDsnProvider->getUsername(),
            'db_password' => $pdoConnectionDsnProvider->getPassword(),
            'lock_mode' => 0,
        ];

        parent::__construct($pdoOrDsn, $options);
    }
}
