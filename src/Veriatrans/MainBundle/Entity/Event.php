<?php

namespace Veriatrans\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Veriatrans\MainBundle\Entity\EventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Event
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
     * @ORM\Column(name="TableName", type="string", length=15)
     */
    private $tableName;

    /**
     * @var integer
     *
     * @ORM\Column(name="ItemID", type="integer")
     */
    private $itemID;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IsViewed", type="boolean")
     */
    private $isViewed;

    /**
     * @var integer
     *
     * @ORM\Column(name="ModifiedAt", type="integer")
     */
    private $modifiedAt;


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
     * Set tableName
     *
     * @param string $tableName
     * @return Event
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Get tableName
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set itemID
     *
     * @param integer $itemID
     * @return Event
     */
    public function setItemID($itemID)
    {
        $this->itemID = $itemID;

        return $this;
    }

    /**
     * Get itemID
     *
     * @return integer
     */
    public function getItemID()
    {
        return $this->itemID;
    }

    /**
     * Set isViewed
     *
     * @param boolean $isViewed
     * @return Event
     */
    public function setIsViewed($isViewed)
    {
        $this->isViewed = $isViewed;

        return $this;
    }

    /**
     * Get isViewed
     *
     * @return boolean 
     */
    public function getIsViewed()
    {
        return $this->isViewed;
    }

    /**
     * Set modifiedAt
     *
     * @param integer $modifiedAt
     * @return Event
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return integer
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

}
