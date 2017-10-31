<?php

namespace Nicorette\CentralBundle\Services;

/**
 * Service pour l'export des données vers calandrier
 * @Service(id="calendar_service")
 * @author  Amir DIMASSI <amir.el-dimassi@proxym-it.com>
 */
class CalendarService
{
    private $em;
    private $container;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }

    public function getData($token){
    	//$this->em = $this->getDoctrine()->getManager();
    	$user = $this->em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
    	$result = array();
    	$result['success'] = 0;
    	$result['year'] = date('Y');
    	$result['month'] = date('m');
    	$result['data'] = array();
    	
        if ( trim($token) != "" && $user != null ) { 
        	$result['success'] = 1;
        	$result['year'] =  $user->getCreatedAt()->format('Y');
        	$result['month'] = $user->getCreatedAt()->format('m');
        	$startDate = $user->getCreatedAt();
        	$endDate = null;
        	$dates = array();
        	foreach($user->getContracts() as $contract){
        		if( $contract->getStopDate() != null ){
	        		$dateSelect = $contract->getStopDate()->format( 'Y-m-d' );
	        		if( !array_key_exists($dateSelect, $dates) ){
	        			$dates[$dateSelect] = array();	        			
	        			$dates[$dateSelect]['date'] = strval(strtotime($contract->getStopDate()->format( 'Y-m-d H:i:s' )) * 1000);
		        		$dates[$dateSelect]['type'] = "datearret";
		        		$dates[$dateSelect]['events'] = array();
	        		}
	        		$tmpEvent = array();
	        		$tmpEvent['typ'] = "datearret";
	        		$tmpEvent['title'] = "Votre Date d'arrêt";
	        		$tmpEvent['description'] = "A parti de ce jour, votre objectif est 0 cigarette";
	        		$dates[$dateSelect]['events'][] = $tmpEvent;
	        		
	        		$date = $contract->getStopDate();
	        		if( $startDate <= $date && ($endDate == null || $endDate <= $date ) ){
	        			$endDate = $date;
	        		}
        		}
        	}
        	if( $endDate== null ){
        		$datetmp = new \DateTime('now');
        		$datetmp->setTimestamp($startDate->getTimestamp());
        		$datetmp->add(new \DateInterval('P4M'));
        		$endDate = new \DateTime('now');
        		//echo $startDate->format( 'Y-m-d' ).'<br>';
        		if( $datetmp < $endDate ){
        			$endDate = $datetmp;
        		}
        		//echo $endDate->format( 'Y-m-d' );
        	}
        	
        	$endDate->setTime(0, 0, 0);
        	$startDate->setTime(0, 0, 0);
        	
        	$answers = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($user, 'PANIC_BUTTON_CRACKED');
        	foreach ($answers as $answer){
        		$tmp = array();
        		$dateSelect = $answer->getCreatedAt()->format( 'Y-m-d' );
        		if( !array_key_exists($dateSelect, $dates) ){
        			$dates[$dateSelect] = array();
        			$dates[$dateSelect]['date'] = strval(strtotime($answer->getCreatedAt()->format( 'Y-m-d H:i:s' )) * 1000);
        			$dates[$dateSelect]['type'] = "avezfumer";
        			$dates[$dateSelect]['events'] = array();
        		}
        		$tmpEvent = array();
        		$tmpEvent['typ'] = "avezfumer";
        		$tmpEvent['title'] = "Vous avez craqué et fumé une cigarette.";
        		$tmpEvent['description'] = "";
        		$dates[$dateSelect]['events'][] = $tmpEvent;
        	}
        	
        	$answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($user, $this->container->getParameter('avez_vous_atteint_votre_objectif_de_reduction'));
        	foreach ($answers as $answer){
        		$dateSelect = $answer->getCreatedAt()->format( 'Y-m-d' );
        		if( !array_key_exists($dateSelect, $dates) ){
        			$dates[$dateSelect] = array();
        			$dates[$dateSelect]['date'] = strval(strtotime($answer->getCreatedAt()->format( 'Y-m-d H:i:s' )) * 1000);
        			$dates[$dateSelect]['type'] = ( $answer->getChoice()->getId() == 72 ? "":"pas" )."objectif";
        			$dates[$dateSelect]['events'] = array();
        		}
        		$tmpEvent = array();
        		$tmpEvent['typ'] = ( $answer->getChoice()->getId() == 72 ? "":"pas" )."objectif";
        		$tmpEvent['title'] = "Votre objectif de réduction était de ".($answer->getDayTarget()!= null?$answer->getDayTarget():0)." cigarettes.";
        		$tmpEvent['description'] = "Vous ".( $answer->getChoice()->getId() == 72 ? "avez":"n'avez pas" )." atteint votre objectif !";
        		$dates[$dateSelect]['events'][] = $tmpEvent;
        	}
        	
        	$date_ = $startDate;
        	while ( $date_ <= $endDate ){
        		$tmp = array();
        		$dateSelect = $date_->format( 'Y-m-d' );
        		if( !array_key_exists($dateSelect, $dates) ){
        			$dates[$dateSelect] = array();
        			$dates[$dateSelect]['date'] = strval(strtotime($date_->format( 'Y-m-d H:i:s' ))*1000);
        			$dates[$dateSelect]['type'] = "preparation";
        			$dates[$dateSelect]['events'] = array();
        		}
        		$tmpEvent = array();
        		$tmpEvent['typ'] = "preparation";
        		$tmpEvent['title'] = "";
        		$tmpEvent['description'] = "";
        		$dates[$dateSelect]['events'][] = $tmpEvent;
        		
        		$date_->add(new \DateInterval('P1D'));
        	}
        	$result['data'] = array_values($dates);
        }
    	
        return $result;
    }

}