<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Nicorette\CentralBundle\Entity\PointHistory;

/**
 * Tools Service 
 * @Service(id="tools_service")
 * @author  Maher Dalla <maher.dalla@proxym-it.com>
 */

class ToolsService {
	
	private $em;
	private $container;
	
	/**
	 * @var array
	 */
	private static $scoreParams = array(
			'C' => 0,
			'P' => 0,
			'A' => 0,
			'M' => 0,
			'Beh' => 0,
			'Ppath' => 0,
			'Psoc' => 0,
			'Phys' => 0,
			'Rew' => 0,
			'C/R' => 0,
			'Fagerstrom' => 0,
			'MotHPres' => 0,
			'MotHFut' => 0,
			'MotSoc' => 0,
			'MotMon' => 0,
			'MotSelf' => 0,
			'OthSmok' => 0
	);
	
	public function __construct($container) {
		$this->em = $container->get('doctrine')->getManager();
		$this->container = $container;
	}
	
	public function getUserCurrentStep($user){
		
		$now = new \DateTime();
		$feedback1 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_1');
		$feedback2 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_2');
		$feedback3 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_3');
		//return 'dashboard';
		
		if(!$feedback1 && !$feedback2 && !$feedback3){
			return 'quiz/1';
		}elseif($feedback1 && !$feedback2){
			return 'quiz/2';
		}elseif($feedback1 && $feedback2 && !$feedback3){
			return 'quiz/3';
		}elseif($feedback1 && $feedback2 && $feedback3){
			if($now->diff($feedback1->getUpdatedAt())->m >= 3){
				return 'quiz/1';
			}elseif($now->diff($feedback2->getUpdatedAt())->m >= 3){
				return 'quiz/2';
			}elseif($now->diff($feedback3->getUpdatedAt())->m >= 3){
				return 'quiz/3';
			}elseif($this->getContractUrl($user)){
				return $this->getContractUrl($user);
			}
		}
		return 'mon-bilan';
	}
	
	public function calculateScore($answers){
		foreach($this->getListAnswers($answers) as $answerId){
			$Choice = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($answerId);
			$scoring = $Choice?$Choice->getScoring():null;
			foreach($scoring as $key => $score){
				self::$scoreParams[$key] += $score;
			}
		}
		return self::$scoreParams ;
	}
	
	private function mergeScore($scoreA, $scoreB){
		foreach($scoreA as $key => $score){
			$scoreA[$key] += $scoreB[$key];
		}
		return $scoreA;
	}
	
	public function calculateFeedbackScore($score, $code){
		
		switch ($code) {
			case 'FEEDBACK_1':
				return $score;
				break;
			case 'FEEDBACK_2':
				$answers = $this->container->get('session')->get('FEEDBACK_1');
				$score1 = $this->calculateScore($answers);
				return $this->mergeScore($score, $score1);
			case 'FEEDBACK_3':
				$answers1 = $this->container->get('session')->get('FEEDBACK_1');
				$score1 = $this->calculateScore($answers1);
				$answers2 = $this->container->get('session')->get('FEEDBACK_2');
				$score2 = $this->calculateScore($answers2);
				return $this->mergeScore($score, $this->mergeScore($score2, $score1));
		}
		return $score;
		
	}
	
	public function getFeedbackByScore($code, $answers){
		$score = $this->calculateFeedbackScore($this->calculateScore($answers), $code);
		$this->container->get('session')->set('score', $score);
		$params = $this->container->getParameter($code);
		$feedbackTexts = array();
		//var_dump($score);
		switch ($code) {
			case 'FEEDBACK_1':
				if($score['Ppath'] > 5 && $score['C/R'] > 5){
					$feedbackTexts['profil'] = $params['profil']['text1'];
					return $feedbackTexts;
				}elseif($score['Ppath'] > 5 && $score['C/R'] <= 5){
					$feedbackTexts['profil'] = $params['profil']['text2'];
					return $feedbackTexts;
				}elseif($score['Ppath'] <= 5 && $score['C/R'] > 5){
					$feedbackTexts['profil'] = $params['profil']['text3'];
					return $feedbackTexts;
				}elseif($score['Ppath'] <= 5 && $score['C/R'] <= 5){
					$feedbackTexts['profil'] = $params['profil']['text4'];
					return $feedbackTexts;
				}
				break;
			case 'FEEDBACK_2':
				$feedbackScore = array();
				/*profil 1*/
				if($score['Beh'] > 5 && $score['Rew'] > 5){
					$feedbackScore['profil'] = $params['profil']['text1'];
				}elseif($score['Beh'] > 5 && $score['Rew'] <= 5){
					$feedbackScore['profil'] = $params['profil']['text2'];
				}elseif($score['Beh'] <= 5 && $score['Rew'] > 5){
					$feedbackScore['profil'] = $params['profil']['text3'];
				}elseif($score['Beh'] <= 5 && $score['Rew'] <= 5){
					$feedbackScore['profil'] = $params['profil']['text4'];
				}
				
				/* profil 2*/
				if($score['Psoc'] > 5){
					$feedbackScore['profil2'] = $params['profil_2']['text1'];
				}else{
					$feedbackScore['profil2'] = $params['profil_2']['text2'];
				}
				 /*motivation*/
				$motivation = false;
				foreach($answers as $answerFeedback2){
					if(count($answerFeedback2) > 2)
						$motivation = true;
				}
				
				if($motivation){
					$feedbackScore['motivation'] = $params['motivation']['text7'];
				}elseif($score['MotHPres'] && $score['MotMon']){
					$feedbackScore['motivation'] = $params['motivation']['text1'];
				}elseif($score['MotHFut'] && $score['MotMon']){
					$feedbackScore['motivation'] = $params['motivation']['text1'];
				}elseif(($score['MotHPres'] && $score['MotSoc']) || ($score['MotHFut'] && $score['MotSoc'])){
					$feedbackScore['motivation'] = $params['motivation']['text2'];
				}elseif(($score['MotHPres'] && $score['MotHFut']) || ($score['MotHPres'] && $score['MotSelf']) || ($score['MotHFut'] && $score['MotSelf'])){
					$feedbackScore['motivation'] = $params['motivation']['text3'];
				}elseif($score['MotMon'] && $score['MotSoc']){
					$feedbackScore['motivation'] = $params['motivation']['text4'];
				}elseif($score['MotMon'] && $score['MotSelf']){
						$feedbackScore['motivation'] = $params['motivation']['text5'];
				}elseif($score['MotSoc'] && $score['MotSelf']){
					$feedbackScore['motivation'] = $params['motivation']['text6'];
				}
				return $feedbackScore;
				break;
			case 'FEEDBACK_3':
				if($score['Fagerstrom'] > 5){
					return array('profil'=>$params['profil']['text1'],'profil_2'=>$params['profil']['text1_2']);
				}elseif($score['Fagerstrom'] <= 5){
					return array('profil'=>$params['profil']['text2']);
				}
				break;
		}
		
	}
	
	private function getListAnswers($answers){
		$answersList = array();
		if(count($answers)>0):
			foreach($answers as $answer){
				
				foreach($answer as $choice){
					//var_dump($choice);
					if(isset($choice['answerId'])){
						if(isset($choice['YesNo'])){
							if($choice['YesNo'] !== 0){
								$answersList[] = $choice['answerId'];
							}
						}else{
							$answersList[] = $choice['answerId'];
						}
					}
				}
			}
		endif;
		return $answersList;
	}
	
	public function getContractUrl($user){
		if(count($user->getContracts()) == 0 && !$user->getFixLater()){
			$contract = $this->container->getParameter('contract2');
			$answers = $this->getUserInitQuizQAnswers($user);
			if($answers){
				if(isset($answers['choice'])){
					foreach($answers['choice'] as $answer){
						if(in_array($answer, $contract)){
							return 'mon-contrat/edition';
						}
					}
				}
				return 'mon-contrat/confirmer';
			}else{
				return 'mon-bilan';
			}
		}else{
			return 'mon-bilan';
		}
	}
	
	public function getNotFixContrat($user){
		if(count($user->getContracts()) == 0){
			$contract = $this->container->getParameter('contract2');
			$answers = $this->getUserInitQuizQAnswers($user);
			var_dump($user->getJanrainId());
			var_dump($contract);die;
			if($answers){
				if(isset($answers['choice'])){
					foreach($answers['choice'] as $answer){
						if(in_array($answer, $contract)){
							return 'mon-contrat/edition';
						}
					}
				}
				return 'mon-contrat/confirmer';
			}
		}
	}
	
	public function getUserInitQuizQAnswers($user){
		$listAnswersId = array();
		$feedback1 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_1');
		$feedback2 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_2');
		$feedback3 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_3');
		if($feedback1):
			foreach($feedback1->getAnswers() as $answer){
				if($answer->getAnswerText()){
					$listAnswersId['input'][] = $answer->getAnswerText();
				}else{
					$listAnswersId['choice'][] = $answer->getChoiceId();
				}
			}
		endif;
		if($feedback2):
			foreach($feedback2->getAnswers() as $answer){
				if($answer->getAnswerText()){
					$listAnswersId['input'][] = $answer->getAnswerText();
				}else{
					$listAnswersId['choice'][] = $answer->getChoiceId();
				}
			}
		endif;
		if($feedback3):
			foreach($feedback3->getAnswers() as $answer){
				if($answer->getAnswerText()){
					$listAnswersId['input'][] = $answer->getAnswerText();
				}else{
					$listAnswersId['choice'][] = $answer->getChoiceId();
				}
			}
		endif;
		if($feedback1 && $feedback2 && $feedback3){
			return $listAnswersId;
		}else{
			return false;
		}
		
	}
	
	public function addPoint($type, $entity, $remove=null){
		$points = $this->container->getParameter('points');
		$oldEntity = $this->em->getRepository('NicoretteCentralBundle:PointHistory')->findOneByType($type);
		if(!$oldEntity || $type == 'parrain_create' || $type == 'patient_create'){
			$pointHistory = new PointHistory();
			$pointHistory->setPatient($entity);
			$pointHistory->setType($type);
			$pointHistory->setNbPoint($remove?$points[$type]:$points[$type]);
			$this->em->persist($pointHistory);
		}
	}



    public function addUserPoint($user,$type,$value,$em){
        $point=new PointHistory();
        $point->setNbPoint($value);
        $point->setType($type);
        $point->setPatient($user);
        $em->Persist($point);
        $em->flush();
    }
    
    public function getTmpQuizAnswers($user){
    	$listAnswersId = array();
    	$feedback1 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_1');
    	$feedback2 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_2');
    	$feedback3 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($user, 'FEEDBACK_3');
    	if($feedback1):
    	foreach($feedback1->getAnswers() as $answer){
    		if($answer->getAnswerText()){
    			$listAnswersId['input'][] = $answer->getAnswerText();
    		}else{
    			$listAnswersId['choice'][] = $answer->getChoiceId();
    		}
    	}
    	endif;
    	if($feedback2):
    	foreach($feedback2->getAnswers() as $answer){
    		if($answer->getAnswerText()){
    			$listAnswersId['input'][] = $answer->getAnswerText();
    		}else{
    			$listAnswersId['choice'][] = $answer->getChoiceId();
    		}
    	}
    	endif;
    	if($feedback3):
    	foreach($feedback3->getAnswers() as $answer){
    		if($answer->getAnswerText()){
    			$listAnswersId['input'][] = $answer->getAnswerText();
    		}else{
    			$listAnswersId['choice'][] = $answer->getChoiceId();
    		}
    	}
    	endif;
    	if($feedback1 && $feedback2 && $feedback3){
    		return $listAnswersId;
    	}else{
    		return false;
    	}
    
    }
    
    
}
