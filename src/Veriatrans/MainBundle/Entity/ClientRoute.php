<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientRoute
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Veriatrans\MainBundle\Entity\ClientRouteRepository")
 */
class ClientRoute
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
     * @var integer
     *
     * @ORM\Column(name="DestinationID", type="integer")
     */
    private $destinationID;

    /**
     * @var integer
     *
     * @ORM\Column(name="PaidKm", type="integer")
     */
    private $paidKm;

    /**
     * @var string
     *
     * @ORM\Column(name="PaidTariff", type="decimal", scale=2)
     */
    private $paidTariff;

    /**
     * @var string
     *
     * @ORM\Column(name="Extra", type="string", length=10)
     */
    private $extra;

    /**
     * @var string
     *
     * @ORM\Column(name="Maut", type="string", length=20)
     */
    private $maut;

    /**
     * @var string
     *
     * @ORM\Column(name="CourseCode", type="string", length=10)
     */
    private $courseCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="ContainerID", type="integer")
     */
    private $containerID;

    /**
     * @var integer
     *
     * @ORM\Column(name="ClientID", type="integer")
     */
    private $clientID;

    /**
     * @var integer
     *
     * @ORM\Column(name="Date", type="integer")
     */
    private $date;


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
     * Set destinationID
     *
     * @param integer $destinationID
     * @return ClientRoute
     */
    public function setDestinationID($destinationID)
    {
        $this->destinationID = $destinationID;

        return $this;
    }

    /**
     * Get destinationID
     *
     * @return integer 
     */
    public function getDestinationID()
    {
        return $this->destinationID;
    }

    /**
     * Set paidKm
     *
     * @param integer $paidKm
     * @return ClientRoute
     */
    public function setPaidKm($paidKm)
    {
        $this->paidKm = $paidKm;

        return $this;
    }

    /**
     * Get paidKm
     *
     * @return integer 
     */
    public function getPaidKm()
    {
        return $this->paidKm;
    }

    /**
     * Set paidTariff
     *
     * @param string $paidTariff
     * @return ClientRoute
     */
    public function setPaidTariff($paidTariff)
    {
        $this->paidTariff = $paidTariff;

        return $this;
    }

    /**
     * Get paidTariff
     *
     * @return string 
     */
    public function getPaidTariff()
    {
        return $this->paidTariff;
    }

    /**
     * Set extra
     *
     * @param string $extra
     * @return ClientRoute
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get extra
     *
     * @return string 
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Set maut
     *
     * @param string $maut
     * @return ClientRoute
     */
    public function setMaut($maut)
    {
        $this->maut = $maut;

        return $this;
    }

    /**
     * Get maut
     *
     * @return string 
     */
    public function getMaut()
    {
        return $this->maut;
    }

    /**
     * Set courseCode
     *
     * @param string $courseCode
     * @return ClientRoute
     */
    public function setCourseCode($courseCode)
    {
        $this->courseCode = $courseCode;

        return $this;
    }

    /**
     * Get courseCode
     *
     * @return string 
     */
    public function getCourseCode()
    {
        return $this->courseCode;
    }

    /**
     * Set containerID
     *
     * @param integer $containerID
     * @return ClientRoute
     */
    public function setContainerID($containerID)
    {
        $this->containerID = $containerID;

        return $this;
    }

    /**
     * Get containerID
     *
     * @return integer 
     */
    public function getContainerID()
    {
        return $this->containerID;
    }

    /**
     * Set date
     *
     * @param integer $date
     * @return ClientRoute
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return integer 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set clientID
     *
     * @param integer $clientID
     * @return ClientRoute
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;

        return $this;
    }

    /**
     * Get clientID
     *
     * @return integer
     */
    public function getClientID()
    {
        return $this->clientID;
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
