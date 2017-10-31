<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Patient
 *
 * @ORM\Table(name="patient_tmp")
 * @ORM\Entity
 */
class PatientTmp
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
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    protected $token;
    
    /**
     * @var string
     * @ORM\Column(name="feedback", type="string", length=255, nullable=true)
     */
    protected $feedback;
    
    /**
     * @var array
     *
     * @ORM\Column(name="answers", type="array",length=16777256, nullable=true)
     */
    protected $answers;



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
     * Set 
     *
     * @param $answers
     * @return PatientTmp
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /** 
     */
    public function getAnswers()
    {
        return $this->answers;
    }
    
    /**
     * Set feedback
     *
     * @param string $feedback
     * @return Patient
     */
    public function setFeedback($feedback)
    {
    	$this->feedback = $feedback;
    
    	return $this;
    }
    
    /**
     * Get feedback
     *
     * @return string
     */
    public function getFeedback()
    {
    	return $this->feedback;
    }

}
