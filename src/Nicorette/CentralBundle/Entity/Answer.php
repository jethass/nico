<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Accessor;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\AnswerRepository")
 * @ExclusionPolicy("all")
 */
class Answer
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
     * @ORM\Column(name="answer_text", type="string", length=255, nullable=true)
     * @Expose
     */
    protected $answerText;
    
    /**
     * @var string
     *
     * @ORM\Column(name="answer_order", type="string", length=255, nullable=true)
     * @Expose
     */
    protected $answerOrder;

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
     * @var quizAnswer
     *
     * @ORM\ManyToOne(targetEntity="QuizAnswer", inversedBy="answers")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="quiz_answer_id", referencedColumnName="id")
     * })
     */
    protected $quizAnswer;
    
    /**
     * @var Patient
     *
     * @ORM\ManyToOne(targetEntity="Choice", inversedBy="answers")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="choice_id", referencedColumnName="id")
     * })
     */
    protected $choice;
    
    /**
     * @Accessor(getter="getChoiceId")
     * @Expose 
     */
    protected $choiceId;
    
    /**
     * @Accessor(getter="getQuestionId")
     * @Expose
     */
    protected $questionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="day_target", type="integer", nullable=true)
     * @Expose
     */
    protected $dayTarget;

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
     * @param string $answerText
     * @return Quiz
     */
    public function setAnswerText($answerText)
    {
        $this->answerText = $answerText;

        return $this;
    }

    /**
     * Get answerText
     *
     * @return string 
     */
    public function getAnswerText()
    {
        return $this->answerText;
    }
    
    /**
     * Set answerOrder
     *
     * @param string $answerOrder
     * @return Quiz
     */
    public function setAnswerOrder($answerOrder)
    {
    	$this->answerOrder = $answerOrder;
    
    	return $this;
    }
    
    /**
     * Get answerOrder
     *
     * @return string
     */
    public function getAnswerOrder()
    {
    	return $this->answerOrder;
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
     * Set QuizAnswer
     *
     * @param QuizAnswer $quizAnswer
     * @return Answer
     */
    public function setQuizAnswer($quizAnswer) {
    	$this->quizAnswer = $quizAnswer;
    	return $this;
    }
    
    /**
     * Get QuizAnswer
     *
     * @return QuizAnswer
     */
    public function getQuizAnswer() {
    	return $this->quizAnswer;
    }
    
    /**
     * Set Choice
     *
     * @param Choice $choice
     * @return Answer
     */
    public function setChoice($choice) {
    	$this->choice = $choice;
    	return $this;
    }
    
    /**
     * Get Choice
     *
     * @return string
     */
    public function getChoice() {
    	return $this->choice;
    }
    
    public function getChoiceId() {
    	return $this->choice?$this->choice->getId():null;
    }
    
    public function getQuestionId() {
    	return $this->choice?$this->choice->getQuestion()->getId():null;
    }

    /**
     * @return int
     */
    public function getDayTarget()
    {
        return $this->dayTarget;
    }

    /**
     * @param int $dayTarget
     */
    public function setDayTarget($dayTarget)
    {
        $this->dayTarget = $dayTarget;
    }

}
