<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Truck
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Truck
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
     * @ORM\Column(name="RegistrationNumber", type="string", length=10)
     */
    private $registrationNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Model", type="string", length=10)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="VIN", type="string", length=20)
     */
    private $vin;

    /**
     * @var integer
     *
     * @ORM\Column(name="CreatedDate", type="integer")
     */
    private $createdDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="ITPDate", type="integer")
     */
    private $itpDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="LicenceDate", type="integer")
     */
    private $licenceDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="RCADate", type="integer")
     */
    private $rcaDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="TachographDate", type="integer")
     */
    private $tachographDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="CMRDate", type="integer")
     */
    private $cmrDate;


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
     * Set registrationNumber
     *
     * @param string $registrationNumber
     * @return Truck
     */
    public function setRegistrationNumber($registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * Get registrationNumber
     *
     * @return string 
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return Truck
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set createdDate
     *
     * @param integer $createdDate
     * @return Truck
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return integer 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set tachographDate
     *
     * @param integer $tachographDate
     * @return Truck
     */
    public function setTachographDate($tachographDate)
    {
        $this->tachographDate = $tachographDate;

        return $this;
    }

    /**
     * Get tachographDate
     *
     * @return integer 
     */
    public function getTachographDate()
    {
        return $this->tachographDate;
    }


    /**
     * Set vin
     *
     * @param string $vin
     * @return Truck
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string 
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set cmrDate
     *
     * @param integer $cmrDate
     * @return Truck
     */
    public function setCmrDate($cmrDate)
    {
        $this->cmrDate = $cmrDate;

        return $this;
    }

    /**
     * Get cmrDate
     *
     * @return integer 
     */
    public function getCmrDate()
    {
        return $this->cmrDate;
    }

    /**
     * Set itpDate
     *
     * @param integer $itpDate
     * @return Truck
     */
    public function setItpDate($itpDate)
    {
        $this->itpDate = $itpDate;

        return $this;
    }

    /**
     * Get itpDate
     *
     * @return integer 
     */
    public function getItpDate()
    {
        return $this->itpDate;
    }

    /**
     * Set licenceDate
     *
     * @param integer $licenceDate
     * @return Truck
     */
    public function setLicenceDate($licenceDate)
    {
        $this->licenceDate = $licenceDate;

        return $this;
    }

    /**
     * Get licenceDate
     *
     * @return integer 
     */
    public function getLicenceDate()
    {
        return $this->licenceDate;
    }

    /**
     * Set rcaDate
     *
     * @param integer $rcaDate
     * @return Truck
     */
    public function setRcaDate($rcaDate)
    {
        $this->rcaDate = $rcaDate;

        return $this;
    }

    /**
     * Get rcaDate
     *
     * @return integer 
     */
    public function getRcaDate()
    {
        return $this->rcaDate;
    }
}
