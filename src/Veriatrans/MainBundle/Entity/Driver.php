<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Driver
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Driver
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
     * @ORM\Column(name="FirstName", type="string", length=15)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="LastName", type="string", length=15)
     */
    private $lastName;

    /**
     * @var integer
     *
     * @ORM\Column(name="PersonalCode", type="string", length=13)
     */
    private $personalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="MedicalNotificationNumber", type="string", length=10)
     */
    private $medicalNotificationNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="MedicalIssueDate", type="integer")
     */
    private $medicalIssueDate;


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
     * Set firstName
     *
     * @param string $firstName
     * @return Driver
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Driver
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set personalCode
     *
     * @param integer $personalCode
     * @return Driver
     */
    public function setPersonalCode($personalCode)
    {
        $this->personalCode = $personalCode;

        return $this;
    }

    /**
     * Get personalCode
     *
     * @return integer 
     */
    public function getPersonalCode()
    {
        return $this->personalCode;
    }

    /**
     * Set medicalNotificationNumber
     *
     * @param string $medicalNotificationNumber
     * @return Driver
     */
    public function setMedicalNotificationNumber($medicalNotificationNumber)
    {
        $this->medicalNotificationNumber = $medicalNotificationNumber;

        return $this;
    }

    /**
     * Get medicalNotificationNumber
     *
     * @return string 
     */
    public function getMedicalNotificationNumber()
    {
        return $this->medicalNotificationNumber;
    }

    /**
     * Set medicalIssueDate
     *
     * @param integer $medicalIssueDate
     * @return Driver
     */
    public function setMedicalIssueDate($medicalIssueDate)
    {
        $this->medicalIssueDate = $medicalIssueDate;

        return $this;
    }

    /**
     * Get medicalIssueDate
     *
     * @return integer 
     */
    public function getMedicalIssueDate()
    {
        return $this->medicalIssueDate;
    }
}
