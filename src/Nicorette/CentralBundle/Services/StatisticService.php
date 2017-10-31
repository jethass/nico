<?php

namespace Nicorette\CentralBundle\Services;

/**
 * Service pour déterminer le nombre de cigarettes économisées, euros, 
 * Objectif du jour, Badge, Nombre de points, Nombre de jour sans tabac	
 * @Service(id="statistic_service")
 * @author  Amir DIMASSI <amir.el-dimassi@proxym-it.com>
 */
class StatisticService
{
    private $em;
    private $container;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }

    public function getData($token){
    	$user = $this->em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
    	$result = array();
    	$result['temptation'] = 0;
    	$result['cracked'] = 0;
    	$result['dangerous'] = 0;
    	$result['risky'] = 0;
    	
        if ( trim($token) != "" && $user != NULL ) {
        	$q = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($user, 'PANIC_BUTTON_TEMPTED_NOT_CRACKED');
        	$result['temptation'] = count($q);
        	$q = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($user, 'PANIC_BUTTON_CRACKED');
        	$result['cracked'] = count($q);
        	
        	$answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($user, $this->container->getParameter('a_quel_moment_avez_vous_craque'));
        	$dangerous = array();
        	foreach ($answers as $answer){
        		if( !in_array($answer->getChoice()->getName(), $dangerous) ){
        			$dangerous[] = $answer->getChoice()->getName();
        		}
        	}
        	$result['dangerous'] = $dangerous;
        	
        	$qs = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($user, $this->container->getParameter('quel_a_ete_le_declenchement_de_votre_envie'));
        	$risky = array();
        	foreach ($qs as $answer){
        		if( !in_array($answer->getChoice()->getName(), $risky) ){
        			$risky[] = $answer->getChoice()->getName();
        		}
        	}
        	$result['risky'] = $risky;
        }  
        return $result;
    }
    
    private function getNumberCigarettesByWeek($cigarettes, $reduction){
    	return $cigarettes * 7 * ( 1 - $reduction );
    }
    
    private function getNumberCigarettesByDay($cigarettes, $reduction){
    	 return $cigarettes * ( 1 - $reduction );
    	 //return $this->getNumberCigarettesByWeek($cigarettes, $reduction) / 7;
    }
}