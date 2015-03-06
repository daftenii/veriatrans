<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContainerTerminal
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ContainerTerminal
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
     * @ORM\Column(name="KaiiNumber", type="string", length=6)
     */
    private $kaiiNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Terminal", type="string", length=40)
     */
    private $terminal;

    /**
     * @var string
     *
     * @ORM\Column(name="Street", type="string", length=50)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="City", type="string", length=20)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="Country", type="string", length=2)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="PostalCode", type="string", length=5)
     */
    private $postalCode;


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
     * Set kaiiNumber
     *
     * @param string $kaiiNumber
     * @return ContainerTerminal
     */
    public function setKaiiNumber($kaiiNumber)
    {
        $this->kaiiNumber = $kaiiNumber;

        return $this;
    }

    /**
     * Get kaiiNumber
     *
     * @return string 
     */
    public function getKaiiNumber()
    {
        return $this->kaiiNumber;
    }

    /**
     * Set terminal
     *
     * @param string $terminal
     * @return ContainerTerminal
     */
    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * Get terminal
     *
     * @return string 
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return ContainerTerminal
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ContainerTerminal
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return ContainerTerminal
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return ContainerTerminal
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
}
