<?php

namespace ApplicationBundle\Communication\DataTransferObjects;

/**
 * Data Transfer Object
 *
 * The concept of having DTO's is to avoid any kind of logic dependency in the data communicated between
 * Bundles/Models/Services or other instances, this not only reduce the coupling in the code but also help to reduce all
 * the Cyclic dependencies in the code.
 *
 * DTO's in this architecture are an exception to the rule of dependencies, they sit in a CommonBundle (this bundle
 * should not have complex classes or business rules at all) once the dependency on a DTO does not meant a dependency
 * to a specific bundle (and this make the coupling even minor), for example, two different bundles could transfer DTOs
 * of the type DevelopersDto but they are not realated to each other in a real case scenario most likely the bundle
 * should extend the DTO because usually new fields would be required and if for any reason a new bundle is set in place
 * to replace an old one, will still have retro-compatibility with older Bundles that only use the basic structure of
 * the original DTO).
 *
 * Please also check (for educational reasons only):
 * @see \DevelopersBundle\Persistence\Entity\Developer;
 *
 * @package ApplicationBundle\Communication\DataTransferObjects
 */
class DevelopersDto
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
}
