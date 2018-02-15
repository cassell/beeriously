<?php
declare(strict_types=1);

namespace Beeriously\Application\SessionHandler;

interface PdoConnectionDsnProviderInterface
{
    public function getPdoDsn(): string;

    public function getUsername(): string;

    public function getPassword(): string;
}