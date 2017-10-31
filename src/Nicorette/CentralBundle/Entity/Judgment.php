<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Judgment
 *
 * @ORM\Table(name="judgment")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\JudgmentRepository")
 */
class Judgment
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
     * @ORM\Column(name="contain", type="integer")
     */
    private $contain;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="frequency", type="integer")
     */
    private $frequency;

    /**
     * @var integer
     *
     * @ORM\Column(name="personalization", type="integer")
     */
    private $personalization;

    /**
     * @var integer
     *
     * @ORM\Column(name="useful", type="integer")
     */
    private $useful;

    /**
     * @var Patient
     *
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="judgments")
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
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;


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
     * Set contain
     *
     * @param integer $contain
     * @return Judgment
     */
    public function setContain($contain)
    {
        $this->contain = $contain;

        return $this;
    }

    /**
     * Get contain
     *
     * @return integer
     */
    public function getContain()
    {
        return $this->contain;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Judgment
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set frequency
     *
     * @param integer $frequency
     * @return Judgment
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return integer
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set personalization
     *
     * @param integer $personalization
     * @return Judgment
     */
    public function setPersonalization($personalization)
    {
        $this->personalization = $personalization;

        return $this;
    }

    /**
     * Get personalization
     *
     * @return integer
     */
    public function getPersonalization()
    {
        return $this->personalization;
    }

    /**
     * Set useful
     *
     * @param integer $useful
     * @return Judgment
     */
    public function setUseful($useful)
    {
        $this->useful = $useful;

        return $this;
    }

    /**
     * Get useful
     *
     * @return integer
     */
    public function getUseful()
    {
        return $this->useful;
    }

    /**
     * @return Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param Patient $patient
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
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

    public function setData($request, $user)
    {
        $this->setContain($request->get('contain'));
        $this->setDuration($request->get('duration'));
        $this->setFrequency($request->get('frequency'));
        $this->setPersonalization($request->get('personalization'));
        $this->setUseful($request->get('useful'));
        $this->setPatient($user);
    }
}
