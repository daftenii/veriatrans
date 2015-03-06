<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trailer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Trailer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="TrailerNumber", type="string", length=20)
     */
    private $trailerNumber;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set trailerNumber
     *
     * @param string $trailerNumber
     * @return Trailer
     */
    public function setTrailerNumber($trailerNumber)
    {
        $this->trailerNumber = $trailerNumber;

        return $this;
    }

    /**
     * Get trailerNumber
     *
     * @return string 
     */
    public function getTrailerNumber()
    {
        return $this->trailerNumber;
    }
}
