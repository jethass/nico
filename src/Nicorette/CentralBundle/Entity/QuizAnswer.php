<?php

namespace Nicorette\CentralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Answer
 *
 * @ORM\Table(name="quiz_answer")
 * @ORM\Entity(repositoryClass="Nicorette\CentralBundle\Repository\QuizAnswerRepository")
 */
class QuizAnswer
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
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="quizAnswers")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     * })
     */
    protected $patient;
    
    /**
     * @var Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="quizAnswers")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     * })
     */
    protected $quiz;
    
    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="quizAnswer", cascade={"remove"})
     * */
    protected $answers;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->answers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Answer
     */
    public function setPatient($patient) {
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
     * Set Quiz
     *
     * @param Quiz $quiz
     * @return Answer
     */
    public function setQuiz($quiz) {
    	$this->quiz = $quiz;
    	return $this;
    }
    
    /**
     * Get Quiz
     *
     * @return Quiz
     */
    public function getQuiz() {
    	return $this->quiz;
    }
    
    /**
     * Add QuizAnswer
     *
     * @param $answer
     * @return QuizAnswer
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
    
    public function setData($quiz, $user){
    	$this->setQuiz($quiz);
    	$this->setPatient($user);
    }
    public function __toString(){
        return (string)$this->getId();
    }
}
