<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Choice
 *
 * @ORM\Table(name="choice")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\ChoiceRepository")
 * @ExclusionPolicy("all")
 */
class Choice
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
     * @var array
     *
     * @ORM\Column(name="scoring", type="array", length=16777256, nullable=true)
     */
    protected $scoring;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="next_question", type="integer", nullable=true)
     * @Expose
     */
    protected $nextQuestion;
    
    /**
     * @var array
     *
     * @ORM\Column(name="renamed_question", type="array",length=16777256, nullable=true)
     * @Expose
     */
    protected $renamedQuestion;
    
    /**
     * @var array
     *
     * @ORM\Column(name="hide_question", type="array",length=16777256, nullable=true)
     * @Expose
     */
    protected $hideQuestion;
    
    /**
     * @var text
     *
     * @ORM\Column(name="text_type", type="integer", nullable=true)
     * @Expose
     */
    protected $textType;
    
    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="choices")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * })
     */
    protected $question;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="choice")
     * */
    protected $answers;
    
    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="choice")
     * */
    protected $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set id
     *
     * @param integer $id
     * @return Choice
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
     * @return Choice
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
     * Set nextQuestion
     *
     * @param integer $nextQuestion
     * @return Choice
     */
    public function setNextQuestion($nextQuestion)
    {
    	$this->nextQuestion = $nextQuestion;
    
    	return $this;
    }
    
    /**
     * Get nextQuestion
     *
     * @return integer
     */
    public function getNextQuestion()
    {
    	return $this->nextQuestion;
    }
    
    /**
     * Set array
     *
     * @param integer $renamedQuestion
     * @return Choice
     */
    public function setRenamedQuestion($renamedQuestion)
    {
    	$this->renamedQuestion = $renamedQuestion;
    
    	return $this;
    }
    
    /**
     * Get array
     *
     * @return integer
     */
    public function getRenamedQuestion()
    {
    	return $this->renamedQuestion;
    }
    
    /**
     * Set array
     *
     * @param integer $hideQuestion
     * @return Choice
     */
    public function setHideQuestion($hideQuestion)
    {
    	$this->hideQuestion = $hideQuestion;
    
    	return $this;
    }
    
    /**
     * Get array
     *
     * @return integer
     */
    public function getHideQuestion()
    {
    	return $this->hideQuestion;
    }

    /**
     * Set scoring
     *
     * @param string $scoring
     * @return Choice
     */
    public function setScoring($scoring)
    {
        $this->scoring = $scoring;

        return $this;
    }

    /**
     * Get scoring
     *
     * @return string 
     */
    public function getScoring()
    {
        return $this->scoring;
    }
    
    /**
     * Set textType
     *
     * @param integer $textType
     * @return Choice
     */
    public function setTextType($textType)
    {
    	$this->textType = $textType;
    
    	return $this;
    }
    
    /**
     * Get textType
     *
     * @return text
     */
    public function getTextType()
    {
    	return $this->textType;
    }

    /**
     * Set question
     *
     * @param \Nicorette\CentralBundle\Entity\Question $question
     * @return Choice
     */
    public function setQuestion(\Nicorette\CentralBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Nicorette\CentralBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Add choice
     *
     * @param $answer
     * @return Choice
     */
    public function addAnswer($answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param $answer
     */
    public function removeAnswer($answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }
    
    /**
     * Add choice
     *
     * @param $product
     * @return Choice
     */
    public function addProduct($product)
    {
    	$this->products[] = $product;
    
    	return $this;
    }
    
    /**
     * Remove product
     *
     * @param $product
     */
    public function removeProduct($product)
    {
    	$this->products->removeElement($product);
    }
    
    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
    	return $this->products;
    }
}
