<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Nicorette\CentralBundle\Entity\Answer;
use Nicorette\CentralBundle\Entity\QuizAnswer;
use Nicorette\CentralBundle\Entity\Contact;
use Nicorette\CentralBundle\Entity\PointHistory;
use Nicorette\CentralBundle\Entity\PatientTmp;

class SessionService extends Session
{

    private $em;
    private $toolsService;

    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null,$em, $toolsService)
    {
        parent::__construct($storage, $attributes, $flashes);
        $this->em = $em;
        $this->toolsService = $toolsService;
    }
    
    public function setFeedbackAnswers($feedback, $answers)
    {
    	$this->set($feedback, $answers);
    }
    
    public function getFeedbackAnswers($feedback)
    {
    	return $this->get($feedback);
    }
    
    public function saveFeedbackAnswers($feedback, $quizAnswer, $user, $points)
    {
    	$answers = $this->get($feedback);
    	$choiceEntity = null;
    	foreach ($answers as $key => $data):
    		if($key == 'parrains' && count($data)){
    			foreach ($data as $parrain):
    				if(isset($parrain['tel']) && $parrain['tel']){
	    				$contact = new Contact();
	    				$contact->setName(isset($parrain['name'])?$parrain['name']:null);
	    				$contact->setEmail(isset($parrain['mail'])?$parrain['mail']:null);
	    				$contact->setPhone(isset($parrain['tel'])?$parrain['tel']:null);
	    				$contact->setPatient($user?$user:null);
	    				$this->em->persist($contact);

                        /*add points*/
                        $this->toolsService->addPoint('parrain_create', $user);

                        $this->em->flush();
    				}
    			endforeach;
    		}else{
	    		foreach ($data as $choice):
		    		if(isset($choice['answerId'])){
				    	if(isset($choice['YesNo'])){
				    		if($choice['YesNo'] !== 0){
				    			$choiceEntity = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($choice['answerId']);
				    		}
				    	}else{
				    		$choiceEntity = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($choice['answerId']);
				    	}
		    			if($choiceEntity){
				    		$answer = $this->em->getRepository('NicoretteCentralBundle:Answer')->findOneBy(array('choice'=>$choiceEntity, 'quizAnswer' => $quizAnswer));
				    		$answer = $answer?$answer:new Answer();
				    		$answer->setQuizAnswer($quizAnswer);
				    		$answer->setChoice($choiceEntity);
				    		if(isset($choice['inputValue'])){
				    			$answer->setAnswerText($choice['inputValue']);
				    		}
				    		if(isset($choice['order'])){
				    			$answer->setAnswerOrder($choice['order']);
				    		}
				    		$this->em->persist($answer);
				    		$this->em->flush();
		    			}
	    			}
			    endforeach;
    		}
    	endforeach;
    }
    
    public function saveAllFeedbackAnswers($user, $points)
    {
    	$choiceEntity = null;
    	if($user){
	    	$initQuizes = array('FEEDBACK_1', 'FEEDBACK_2', 'FEEDBACK_3');
	    	foreach($initQuizes as $key => $feedback):
	    		$answers = $this->getFeedbackAnswers($feedback);
	    		if(!$answers)
	    			unset($initQuizes[$key]);
	    	endforeach;
	    	if(count($initQuizes)){
		    	foreach($initQuizes as $feedback):
		    		$quiz = $this->em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($feedback);
		    		$quizAnswer = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findOneBy(array('patient' => $user,'quiz'=> $quiz));
		    		if(!$quizAnswer){
		    			$quizAnswer = new QuizAnswer();
		    			$quizAnswer->setData($quiz, $user);
		    			$this->em->persist($quizAnswer);
		    		
		    			$answers = $this->getFeedbackAnswers($feedback);
		    			if($answers){
			    			foreach ($answers as $key => $data):
				    			if($key == 'parrains' && count($data)){
				    				foreach ($data as $parrain):
				    					if(isset($parrain['tel']) && $parrain['tel']){
						    				$contact = new Contact();
						    				$contact->setName(isset($parrain['name'])?$parrain['name']:null);
						    				$contact->setEmail(isset($parrain['mail'])?$parrain['mail']:null);
						    				$contact->setPhone(isset($parrain['tel'])?$parrain['tel']:null);
						    				$contact->setPatient($user?$user:null);
						    				$this->em->persist($contact);

                                            /*add points*/
                                            $this->toolsService->addPoint('parrain_create', $user);

                                            $this->em->flush();
				    					}
				    				endforeach;
				    			}else{
				    				foreach ($data as $choice):
				    					if(isset($choice['answerId'])){
						    				if(isset($choice['YesNo'])){
						    					if($choice['YesNo'] !== 0){
						    						$choiceEntity = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($choice['answerId']);
						    					}
						    				}else{
						    					$choiceEntity = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($choice['answerId']);
						    				}
				    						if($choiceEntity):
				    							$answer = $this->em->getRepository('NicoretteCentralBundle:Answer')->findOneBy(array('choice'=>$choiceEntity, 'quizAnswer' => $quizAnswer));
				    							$answer = $answer?$answer:new Answer();
				    							$answer->setQuizAnswer($quizAnswer);
				    							$answer->setChoice($choiceEntity);
				    							if(isset($choice['inputValue'])):
				    								$answer->setAnswerText($choice['inputValue']);
				    							endif;
				    							if(isset($choice['order'])){
				    								$answer->setAnswerOrder($choice['order']);
				    							}
				    							$this->em->persist($answer);
				    							$this->em->flush();
				    						endif;
				    						
				    					}
				    				endforeach;
				    			}
			    			endforeach;
		    			}
		    		}
		    		$this->setFeedbackAnswers($feedback, null);
		    	endforeach;
		    	try {
		    		$this->em->flush();
		    		
		    		return true;
		    	} catch (Exception $e) {
		    		return false;
		    	}
    		}
    	}
    	return true;
    }
    
    public function saveTmpFeedback($token){
    	$initQuizes = array('FEEDBACK_1', 'FEEDBACK_2', 'FEEDBACK_3');
    	foreach($initQuizes as $key => $feedback):
    		if($this->getFeedbackAnswers($feedback)){
	    		$patientTmp = new PatientTmp();
	    		$patientTmp->setToken($token);
	    		$patientTmp->setFeedback($feedback);
	    		$patientTmp->setAnswers($this->getFeedbackAnswers($feedback));
	    		$this->em->persist($patientTmp);
	    		$this->em->flush();
    		}
    	endforeach;
    }
    
    public function saveAnswersFromTmp($token, $points, $user){
    	$tmps = $this->em->getRepository('NicoretteCentralBundle:PatientTmp')->findByToken($token);
    	if(count($tmps) > 0){
	    	foreach($tmps as $tmp){
	    		$this->setFeedbackAnswers($tmp->getFeedback(), $tmp->getAnswers());
	    		//var_dump($tmp->getFeedback());
	    		$this->em->remove($tmp);
	    		$this->em->flush();
	    	}
    	}
    	$this->saveAllFeedbackAnswers($user, $points);
    }
    
}

?>