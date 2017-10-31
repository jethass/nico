<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Question
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
     * @ORM\Column(name="second_name", type="string", length=255, nullable=true)
	 * @Expose
     */
    protected $secondName;

    /**
     * @var string
     *
     * @ORM\Column(name="balise", type="string", length=255, nullable=true)
	 * @Expose
     */
    protected $balise;

    /**
     * @var string
     *
     * @ORM\Column(name="input_type", type="integer", nullable=true)
	 * @Expose
     */
    protected $inputType;

    /**
     * @var integer
     *
     * @ORM\Column(name="answer_required", type="integer", nullable=true)
     * @Expose
     */
    protected $answerRequired;

    /**
     * @var integer
     *
     * @ORM\Column(name="answer_multiple", type="integer", nullable=true)
	 * @Expose
     */
    protected $answerMultiple;
    
    /**
     * @var string
     *
     * @ORM\Column(name="question_order", type="integer", nullable=true)
     * @Expose
     */
    protected $questionOrder;

    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="questions")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     * })
     */
    protected $quiz;
    
    /**
     * @ORM\OneToMany(targetEntity="Choice", mappedBy="question")
     * @Expose
     * */
    public $choices;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->choices = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Question
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
     * Set name
     *
     * @param string $name
     * @return Question
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
     * Set secondName
     *
     * @param string $secondName
     * @return Question
     */
    public function setSecondName($secondName)
    {
    	$this->secondName = $secondName;
    
    	return $this;
    }
    
    /**
     * Get name
     *
     * @return string
     */
    public function getSecondName()
    {
    	return $this->secondName;
    }

    /**
     * Set inputType
     *
     * @param integer $inputType
     * @return Question
     */
    public function setInputType($inputType)
    {
        $this->inputType = $inputType;

        return $this;
    }

    /**
     * Get inputType
     *
     * @return integer 
     */
    public function getInputType()
    {
        return $this->inputType;
    }

    /**
     * Set answerRequired
     *
     * @param integer $answerRequired
     * @return Question
     */
    public function setAnswerRequired($answerRequired)
    {
        $this->answerRequired = $answerRequired;

        return $this;
    }

    /**
     * Get answerRequired
     *
     * @return integer 
     */
    public function getAnswerRequired()
    {
        return $this->answerRequired;
    }

    /**
     * Set answerMultiple
     *
     * @param integer $answerMultiple
     * @return Question
     */
    public function setAnswerMultiple($answerMultiple)
    {
        $this->answerMultiple = $answerMultiple;

        return $this;
    }

    /**
     * Get answerMultiple
     *
     * @return integer 
     */
    public function getAnswerMultiple()
    {
        return $this->answerMultiple;
    }
    
    /**
     * Set questionOrder
     *
     * @param integer $questionOrder
     * @return Quiz
     */
    public function setQuestionOrder($questionOrder)
    {
    	$this->questionOrder = $questionOrder;
    
    	return $this;
    }
    
    /**
     * Get questionOrder
     *
     * @return integer
     */
    public function getQuestionOrder()
    {
    	return $this->questionOrder;
    }

    /**
     * Set quiz
     *
     * @param \Nicorette\CentralBundle\Entity\Quiz $quiz
     * @return Question
     */
    public function setQuiz(\Nicorette\CentralBundle\Entity\Quiz $quiz)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \Nicorette\CentralBundle\Entity\Quiz 
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
    
    /**
     * Add choice
     *
     * @param $choice
     * @return Question
     */
    public function addChoice($choice)
    {
    	$this->choices[] = $choice;
    
    	return $this;
    }
    
    /**
     * Remove Choice
     *
     * @param $choice
     */
    public function removeChoice($choice)
    {
    	$this->choices->removeElement($choice);
    }
    
    /**
     * Get choices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoices()
    {
    	return $this->choices;
    }

    /**
     * @return string
     */
    public function getBalise()
    {
        return $this->balise;
    }

    /**
     * @param string $balise
     */
    public function setBalise($balise)
    {
        $this->balise = $balise;
    }


}
