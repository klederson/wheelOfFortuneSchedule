<?php

namespace DevelopersBundle\Business\Drivers;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;
use DevelopersBundle\Persistence\Entity\Developer;

/**
 * Driver (here is where the "ugly code goes!!! :P")
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
 * @package DevelopersBundle\Business\Drivers
 */
class DevelopersMockDriverCsv implements DevelopersMockDriverInterface
{
    /*
     * I could use parameters instead of hardcoding here but for the sake of the architecture and avoid new bundles
     * I prefer choose this way
     */
    const SOURCE_FILE = 'developers.csv';

    /**
     * @return array
     */
    public function getDevelopers(): array
    {
        $rawDevelopers = $this->getCsvData();
        $entityDevelopers = $this->transformCsvArrayToEntity($rawDevelopers); //read code doc of this method bellow

        return $this->transformEntityArrayToDto($entityDevelopers);
    }

    /**
     * @param mixed $uuid
     *
     * @return boolean|DevelopersDto
     */
    public function getDeveloper($uuid)
    {
        $developers = $this->getDevelopers();

        foreach($developers as $developer) {
            /** @var $developer DevelopersDto */
            if($developer->getUuid() === $uuid) {
                return $developer;
            }
        }

        return false;
    }

    /**
     * This method exemplify the UNIQUE caracteristic of this Driver, the CSV approach instead of Database, Api, etc...
     *
     * @return array
     */
    protected function getCsvData() : array {
        $file = __DIR__ . '/../../Resources/mock_data/' . self::SOURCE_FILE;

        /*
         * This block of code to read csv was copied and pasted from stackoverflow ... don't be shy in searching for help to avoid reinventing the wheel
         */
        $csv = array_map("str_getcsv", file($file,FILE_SKIP_EMPTY_LINES));
        $keys = array_shift($csv);

        /*
         * just to avoid problems and to make the attributes a bit nice ( givenName instead of GivenName and remove spaces for example )
         */
        foreach($keys as $i => $key) {
            $keys[$i] = str_replace(" ", "", lcfirst(trim($key)));
        }

        foreach ($csv as $i=>$row) {
            $csv[$i] = array_combine($keys, $row);
        }
        /* source: https://stackoverflow.com/questions/5674117/how-do-i-parse-a-csv-file-to-grab-the-column-names-first-then-the-rows-that-rela */

        return $csv;
    }

    /**
     * This method and the other method DevelopersMockDriverCsv::transformEntityToDto() could be combined in one but for
     * educational purposes I choose to make them separated in order to make even more clear the usage and advantages
     * of this presented architecture.
     *
     * @param array $data
     *
     * @return array|Developer
     */
    protected function transformCsvArrayToEntity(array $data) : array {
        $resultSet = [];

        foreach($data as $row) {
            $entity = new Developer(); //Kids this is a horrible practice and its here because I know it't not going to cause any harm to the performance but please avoid new object instances in a loop for the sake of your sanity and the happiness of your colleagues

            $entity->setUuid($row['uuid']);
            $entity->setFname($row['givenName']);
            $entity->setLname($row['surname']);

            $resultSet[] = clone $entity;
        }

        return $resultSet;
    }

    /**
     * @param array|Developer $data
     *
     * @return array|DevelopersDto
     */
    protected function transformEntityArrayToDto(array $data) {
        $resultSet = [];


        foreach($data as $entity) {
            $dto = new DevelopersDto();

            /* @var $entity Developer */
            $dto->setUuid($entity->getUuid());
            $dto->setFirstName($entity->getFname());
            $dto->setLastName($entity->getLname());

            $resultSet[] = clone $dto;
        }

        return $resultSet;
    }
}
