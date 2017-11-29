<?php

namespace DevelopersBundle\Persistence\Entity;

/**
 * Entity Developer
 *
 * This is a very simple Entity and can be used together with different kind of Repositories (database, api-based, etc)
 *
 * One thing to observe here is it has (by design) the attributes $fname and $lname for pedagogical purposes to
 * conceptually differentiate it from the DevelperDto.
 *
 * @see \ApplicationBundle\Communication\DataTransferObjects\DevelopersDto
 *
 * @package DevelopersBundle\Persistence\Entity
 */
class Developer
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $fname;

    /**
     * @var string
     */
    private $lname;

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
    public function getFname(): string
    {
        return $this->fname;
    }

    /**
     * @param string $fname
     */
    public function setFname(string $fname)
    {
        $this->fname = $fname;
    }

    /**
     * @return string
     */
    public function getLname(): string
    {
        return $this->lname;
    }

    /**
     * @param string $lname
     */
    public function setLname(string $lname)
    {
        $this->lname = $lname;
    }
}
