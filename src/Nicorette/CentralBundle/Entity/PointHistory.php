<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PointHistory
 *
 * @ORM\Table(name="point_history")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\PointHistoryRepository")
 */
class PointHistory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    protected $type;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nb_point", type="integer", nullable=true)
     */
    protected $nbPoint;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;
    
    /**
     * @var Patient
     *
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="pointHistories")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     * })
     */
    protected $patient;
    
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Quiz
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Quiz
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set patient
     *
     * @param Patient $patient
     */
    public function setPatient(\Nicorette\CentralBundle\Entity\Patient $patient) {
    	$this->patient = $patient;
    	return $this;
    }
    
    /**
     * Get patient
     *
     * @return string
     */
    public function getPatient() {
    	return $this->patient;
    }
    
    /**
     * Set Type
     *
     * @param string $type
     * @return PointHistory
     */
    public function setType($type) {
    	$this->type = $type;
    	return $this;
    }
    
    /**
     * Get $type
     *
     * @return $type
     */
    public function getType() {
    	return $this->type;
    }
    
    /**
     * Set nbPoint
     *
     * @param integer $nbPoint
     * @return PointHistory
     */
    public function setNbPoint($nbPoint) {
    	$this->nbPoint = $nbPoint;
    	return $this;
    }
    
    /**
     * Get $nbPoint
     *
     * @return $nbPoint
     */
    public function getNbPoint() {
    	return $this->nbPoint;
    }
    
}