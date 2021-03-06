<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Container
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Veriatrans\MainBundle\Entity\ContainerRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Container
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
     * @var boolean
     *
     * @ORM\Column(name="IsDeleted", type="boolean")
     */
    private $isDeleted;

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
     * @return Container
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
     * @return Container
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
     * @return Container
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
     * @return Container
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
     * @return Container
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
     * @return Container
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

    /**
     * Set isDeleted
     *
     * @return boolean
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return integer
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
}
