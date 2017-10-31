<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection as Collection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz")
 * @ORM\Entity
 * @ExclusionPolicy("all") 
 */
class Quiz
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Expose
     */
    protected $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     * @Expose
     */
    protected $code;
    
    /**
     * @var string
     *
     * @ORM\Column(name="step_nbr", type="integer", nullable=true)
     * @Expose
     */
    protected $stepNbr;

    /**
     * @var integer
     *
     * @ORM\Column(name="passed", type="integer", nullable=true)
     * @Expose
     */
    protected $passed;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Expose
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Expose
     */
    protected $updatedAt;
    
    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="quiz")
     * @Expose
     * */
    public $questions;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Quiz
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set code
     *
     * @param string $code
     * @return Quiz
     */
    public function setCode($code)
    {
    	$this->code = $code;
    
    	return $this;
    }
    
    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
    	return $this->code;
    }
    
    /**
     * Set $stepNbr
     *
     * @param string $stepNbr
     * @return Quiz
     */
    public function setStepNbr($stepNbr)
    {
    	$this->stepNbr = $stepNbr;
    
    	return $this;
    }
    
    /**
     * Get stepNbr
     *
     * @return integer
     */
    public function getStepNbr()
    {
    	return $this->stepNbr;
    }

    /**
     * Set passed
     *
     * @param integer $passed
     * @return Quiz
     */
    public function setPassed($passed)
    {
        $this->passed = $passed;

        return $this;
    }

    /**
     * Get passed
     *
     * @return integer 
     */
    public function getPassed()
    {
        return $this->passed;
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
     * Add choice
     *
     * @param $question
     * @return Quiz
     */
    public function addQuestion($question)
    {
    	$this->questions[] = $question;
    
    	return $this;
    }
    
    /**
     * Remove question
     *
     * @param $question
     */
    public function removeQuestion($question)
    {
    	$this->questions->removeElement($question);
    }
    
    /**
     * Get question
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
    	return $this->questions;
    }
    
    
    /**
     * Set question
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function setQuestions($questions)
    {
    	return $this->questions = $questions;
    }
    
}
