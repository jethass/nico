<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Patient
 *
 * @ORM\Table(name="patient")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\PatientRepository")
 */
class Patient
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
     * @var integer
     * @Assert\NotBlank(message = "Vous devez renseigner le uuid.")
     * @ORM\Column(name="janrain_id", type="string", length=255, nullable=true)
     */
    protected $janrainId;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    protected $status;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="fix_later", type="integer", nullable=true)
     */
    protected $fixLater;

    /**
     * @var string
     * @Assert\NotBlank(message = "Vous devez renseigner le token.")
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    protected $token;
    
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
     * @var \DateTime
     * @Assert\DateTime(message = {"expiredAt":"Date non Valide."})
     * @ORM\Column(name="expired_at", type="datetime", nullable=true)
     */
    protected $expiredAt;

    /**
     * @ORM\OneToMany(targetEntity="QuizAnswer", mappedBy="patient", cascade={"remove"})
     * */
    protected $quizAnswers;

    /**
     * @ORM\OneToMany(targetEntity="PatientEconomy", mappedBy="patient", cascade={"remove"})
     * */
    protected $patientEconomys;

    /**
     * @ORM\OneToMany(targetEntity="Nicorette\CentralBundle\Entity\Judgment", mappedBy="patient", cascade={"remove"})
     * */
    protected $judgments;
    
    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="patient", cascade={"persist","remove"})
     * */
    protected $contacts;
    
    /**
     * @ORM\OneToMany(targetEntity="Contract", mappedBy="patient", cascade={"persist","remove"})
     * */
    protected $contracts;
    
    /**
     * @ORM\OneToMany(targetEntity="PointHistory", mappedBy="patient", cascade={"persist", "remove"})
     * */
    protected $pointHistories;

    /**
     * @var boolean
     *
     * @ORM\Column(name="club_alerts", type="boolean", nullable=true)
     */
    private $club_alerts = 0;


    /**
     * @var boolean
     *
     * @ORM\Column(name="johnson_alerts", type="boolean", nullable=true)
     */
    private $johnson_alerts = 0;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quizAnswers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->patientEconomys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->judgments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pointHistories = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set janrainId
     *
     * @param integer $janrainId
     * @return Patient
     */
    public function setJanrainId($janrainId)
    {
    	$this->janrainId = $janrainId;
    
    	return $this;
    }
    
    /**
     * Get janrainId
     *
     * @return integer
     */
    public function getJanrainId()
    {
    	return $this->janrainId;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Patient
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    
    /**
     * Set fixLater
     *
     * @param integer $fixLater
     * @return Patient
     */
    public function setFixLater($fixLater)
    {
    	$this->fixLater = $fixLater;
    
    	return $this;
    }
    
    /**
     * Get $fixLater
     *
     * @return integer
     */
    public function getFixLater()
    {
    	return $this->fixLater;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Patient
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
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

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Patient
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
     * Set expiredAt
     *
     * @param \DateTime $expiredAt
     * @return Patient
     */
    public function setExpiredAt($expiredAt)
    {
    	$this->expiredAt = $expiredAt;
    
    	return $this;
    }
    
    /**
     * Get expiredAt
     *
     * @return \DateTime
     */
    public function getExpiredAt()
    {
    	return $this->expiredAt;
    }

    /**
     * Add QuizAnswer
     *
     * @param $quizAnswer
     * @return Patient
     */
    public function addQuizAnswer($quizAnswer)
    {
        $this->quizAnswers[] = $quizAnswer;

        return $this;
    }

    /**
     * Remove QuizAnswer
     *
     * @param $quizAnswer
     */
    public function removeQuizAnswer($quizAnswer)
    {
        $this->quizAnswers->removeElement($quizAnswer);
    }

    /**
     * Get quizAnswers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuizAnswers()
    {
        return $this->quizAnswers;
    }
    
    /**
     * Add Contract
     *
     * @param $contract
     * @return Patient
     */
    public function addContract($contract)
    {
    	$this->contracts[] = $contract;
    
    	return $this;
    }
    
    /**
     * Remove contract
     *
     * @param $contract
     */
    public function removeContract($contract)
    {
    	$this->contracts->removeElement($contract);
    }
    
    /**
     * Get contracts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
    	return $this->contracts;
    }
    
    /**
     * Add Contact
     *
     * @param $contact
     * @return Patient
     */
    public function addContact($contact)
    {
    	$this->contacts[] = $contact;
    
    	return $this;
    }
    
    /**
     * Remove contact
     *
     * @param $contact
     */
    public function removeContact($contact)
    {
    	$this->contacts->removeElement($contact);
    }
    
    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
    	return $this->contacts;
    }
    
    /**
     * Add PointHistory
     *
     * @param $pointHistory
     * @return Patient
     */
    public function addPointHistory($pointHistory)
    {
    	$this->pointHistories[] = $pointHistory;
    
    	return $this;
    }
    
    /**
     * Remove pointHistory
     *
     * @param $pointHistory
     */
    public function removePointHistory($pointHistory)
    {
    	$this->pointHistories->removeElement($pointHistory);
    }
    
    /**
     * Get pointHistories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPointHistories()
    {
    	return $this->pointHistories;
    }

    /**
     * @return boolean
     */
    public function isClubAlerts()
    {
        return $this->club_alerts;
    }

    /**
     * @param boolean $club_alerts
     */
    public function setClubAlerts($club_alerts)
    {
        $this->club_alerts = $club_alerts;
    }

    /**
     * @return boolean
     */
    public function isJohnsonAlerts()
    {
        return $this->johnson_alerts;
    }

    /**
     * @param boolean $johnson_alerts
     */
    public function setJohnsonAlerts($johnson_alerts)
    {
        $this->johnson_alerts = $johnson_alerts;
    }


    /**
     * Add Judgment
     *
     * @param $judgment
     * @return Patient
     */
    public function addJudgment($judgment)
    {
        $this->judgments[] = $judgment;

        return $this;
    }

    /**
     * Remove Judgment
     *
     * @param $judgment
     */
    public function removeJudgment($judgment)
    {
        $this->judgments->removeElement($judgment);
    }

    /**
     * Get judgments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJudgments()
    {
        return $this->judgments;
    }

    /**
     * Add patientEconomy
     *
     * @param $quizAnswer
     * @return Patient
     */
    public function addPatientEconomy($patientEconomy)
    {
        $this->patientEconomys[] = $patientEconomy;

        return $this;
    }

    /**
     * Remove patientEconomy
     *
     * @param $patientEconomy
     */
    public function removePatientEconomy($patientEconomy)
    {
        $this->patientEconomys->removeElement($patientEconomy);
    }

    /**
     * Get patientEconomys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPatientEconomys()
    {
        return $this->patientEconomys;
    }
    
    public function setData($request, $uuid){
    	$this->setToken($request->get('token'));
    	$this->setJanrainId($uuid);
    	if($request->get('expires')){
	    	$time = strtotime($request->get('expires'));
	    	$date = date('Y-m-d h:i:s',$time);
	    	$expires = ($date != '1970-01-01 01:00:00')?new \DateTime($date):$request->get('expires');
	    	$this->setExpiredAt($expires);
    	}
    }


}
