<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DriverRoute
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Veriatrans\MainBundle\Entity\DriverRouteRepository")
 */
class DriverRoute
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
     * @ORM\Column(name="DriverID", type="integer")
     */
    private $driverID;

    /**
     * @var integer
     *
     * @ORM\Column(name="TruckID", type="integer")
     */
    private $truckID;

    /**
     * @var integer
     *
     * @ORM\Column(name="CurrentKm", type="integer")
     */
    private $currentKm;

    /**
     * @var integer
     *
     * @ORM\Column(name="PastKm", type="integer")
     */
    private $pastKm;

    /**
     * @var string
     *
     * @ORM\Column(name="HighwayPaiment", type="decimal", scale=2)
     */
    private $highwayPaiment;

    /**
     * @var integer
     *
     * @ORM\Column(name="ContainerID", type="integer")
     */
    private $containerID;

    /**
     * @var integer
     *
     * @ORM\Column(name="LoadedWeight", type="integer")
     */
    private $loadedWeight;

    /**
     * @var integer
     *
     * @ORM\Column(name="Date", type="integer")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="DestinationID", type="integer")
     */
    private $destinationID;

    /**
     * @var string
     *
         * @ORM\Column(name="OrderNumber", type="string", length=20)
     */
    private $orderNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="ClientID", type="integer")
     */
    private $clientID;

    /**
     * @var integer
     *
     * @ORM\Column(name="WeekNumber", type="smallint")
     */
    private $weekNumber;

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
     * Set driverID
     *
     * @param integer $driverID
     * @return DriverRoute
     */
    public function setDriverID($driverID)
    {
        $this->driverID = $driverID;

        return $this;
    }

    /**
     * Get driverID
     *
     * @return integer 
     */
    public function getDriverID()
    {
        return $this->driverID;
    }

    /**
     * Set truckID
     *
     * @param integer $truckID
     * @return DriverRoute
     */
    public function setTruckID($truckID)
    {
        $this->truckID = $truckID;

        return $this;
    }

    /**
     * Get truckID
     *
     * @return integer 
     */
    public function getTruckID()
    {
        return $this->truckID;
    }

    /**
     * Set currentKm
     *
     * @param integer $currentKm
     * @return DriverRoute
     */
    public function setCurrentKm($currentKm)
    {
        $this->currentKm = $currentKm;

        return $this;
    }

    /**
     * Get currentKm
     *
     * @return integer 
     */
    public function getCurrentKm()
    {
        return $this->currentKm;
    }

    /**
     * Set pastKm
     *
     * @param integer $pastKm
     * @return DriverRoute
     */
    public function setPastKm($pastKm)
    {
        $this->pastKm = $pastKm;

        return $this;
    }

    /**
     * Get pastKm
     *
     * @return integer 
     */
    public function getPastKm()
    {
        return $this->pastKm;
    }

    /**
     * Set highwayPaiment
     *
     * @param string $highwayPaiment
     * @return DriverRoute
     */
    public function setHighwayPaiment($highwayPaiment)
    {
        $this->highwayPaiment = $highwayPaiment;

        return $this;
    }

    /**
     * Get highwayPaiment
     *
     * @return string 
     */
    public function getHighwayPaiment()
    {
        return $this->highwayPaiment;
    }

    /**
     * Set containerID
     *
     * @param integer $containerID
     * @return DriverRoute
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
     * Set loadedWeight
     *
     * @param integer $loadedWeight
     * @return DriverRoute
     */
    public function setLoadedWeight($loadedWeight)
    {
        $this->loadedWeight = $loadedWeight;

        return $this;
    }

    /**
     * Get loadedWeight
     *
     * @return integer 
     */
    public function getLoadedWeight()
    {
        return $this->loadedWeight;
    }

    /**
     * Set date
     *
     * @param integer $date
     * @return DriverRoute
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
     * Set destinationID
     *
     * @param integer $destinationID
     * @return DriverRoute
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
     * Set orderNumber
     *
     * @param string $orderNumber
     * @return DriverRoute
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string 
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set clientID
     *
     * @param integer $clientID
     * @return DriverRoute
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
     * Set weekNumber
     *
     * @param integer $weekNumber
     * @return DriverRoute
     */
    public function setWeekNumber($weekNumber)
    {
        $this->weekNumber = $weekNumber;

        return $this;
    }

    /**
     * Get weekNumber
     *
     * @return integer 
     */
    public function getWeekNumber()
    {
        return $this->weekNumber;
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
