<?php

namespace DevelopersBundle\Business\Drivers;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;

/**
 * Driver
 *
 * This is just to exemplify the possibility of having different business rules (payment methods, payment providers,
 * gateways for example) without the need to tear apart your business logic because of them.
 *
 * Using this architecture your code is more open for changes and evolution without bringing huge disturbs to your whole
 * application.
 *
 * In this case I just choose to abstract the source of data for Developers in different ways ( Api, Static CSV file,
 * Static Json file, Database using Doctrine, Database using MongoDB, Efemeral sources like Redis or Memcached could
 * also be used - even tho this last two could be ugly practices for this purpose).
 *
 * @see DevelopersMockDriverInterface
 *
 * @package DevelopersBundle\Business\Drivers
 */
class DevelopersMockDriverJsonDriver implements DevelopersMockDriverInterface
{
    public function getDevelopers(): array
    {
        // TODO: Implement getDevelopers() method.
    }

    public function getDeveloper($uuid)
    {
        // TODO: Implement getDeveloper() method.
    }
}
