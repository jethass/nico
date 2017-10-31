<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Contract
 *
 * @ORM\Table(name="contract")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\ContractRepository")
 */
class Contract
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
     * @var \DateTime
     *
     * @ORM\Column(name="stop_date", type="datetime", nullable=true)
     */
    protected $stopDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_cigarette", type="datetime", nullable=true)
     */
    protected $lastCigarette;

    /**
     * si le patient souhaite mettre fin au programme d'arrét nicorette
     * @var integer
     *
     * @ORM\Column(name="quit", type="integer", nullable=true)
     */
    protected $quit;

    /**
     * @var Patient
     *
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="contracts", cascade={"persist","remove"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     * })
     */
    protected $patient;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * Set id
     *
     * @param integer $id
     * @return Contract
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set stopDate
     *
     * @param \DateTime $stopDate
     * @return Contract
     */
    public function setStopDate($stopDate)
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    /**
     * Get stopDate
     *
     * @return \DateTime 
     */
    public function getStopDate()
    {
        return $this->stopDate;
    }

    /**
     * Set lastCigarette
     *
     * @param \DateTime $lastCigarette
     * @return Contract
     */
    public function setLastCigarette($lastCigarette)
    {
        $this->lastCigarette = $lastCigarette;

        return $this;
    }

    /**
     * Get lastCigarette
     *
     * @return \DateTime 
     */
    public function getLastCigarette()
    {
        return $this->lastCigarette;
    }

    /**
     * Set quit
     *
     * @param integer $quit
     * @return Contract
     */
    public function setQuit($quit)
    {
        $this->quit = $quit;

        return $this;
    }

    /**
     * Get quit
     *
     * @return integer 
     */
    public function getQuit()
    {
        return $this->quit;
    }

    /**
     * Set patient
     *
     * @param \Nicorette\CentralBundle\Entity\Patient $patient
     * @return Contract
     */
    public function setPatient(\Nicorette\CentralBundle\Entity\Patient $patient)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get patient
     *
     * @return \Nicorette\CentralBundle\Entity\Patient 
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Patient
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
}
