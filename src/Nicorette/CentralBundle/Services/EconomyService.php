<?php

namespace Nicorette\CentralBundle\Services;

/**
 * Service pour déterminer le nombre de cigarettes économisées, euros, 
 * Objectif du jour, Badge, Nombre de points, Nombre de jour sans tabac	
 * @Service(id="economy_service")
 * @author  Amir DIMASSI <amir.el-dimassi@proxym-it.com>
 */
class EconomyService
{
    private $em;
    private $container;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }

    public function getNumberCigarettesEconomy($token){
    	$user = $this->em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
    	$result = array();
    	$result['cigarettes'] = 0;
    	$result['euros'] = 0;
    	$result['points'] = 0;
    	$result['objectif_jour'] = 0;
    	$result['sans_tabac_1'] = 0;
    	$result['sans_tabac_2'] = 0;
    	$result['badge1'] = false;
    	$result['badge2'] = false;
    	$result['badge3'] = false;
    	$result['badge4'] = false;
    	$result['badge5'] = false;
    	
        if ( trim($token) != "" && $user != NULL ) {
	    	$startCigarettes = 0;
	    	$reduction = $this->container->getParameter('reduction_percentage');
	    	$startDate = $user->getCreatedAt();
	    	$startWeek = $startDate->format('W');
	    	$endDate = new \DateTime('now');
	    	$stopDate = NULL;
        	foreach($user->getContracts() as $contract){
        		if( $contract->getStopDate() != NULL ){
        			$date = $contract->getStopDate();
        			//if( $startDate <= $date && ($stopDate == NULL || $stopDate <= $date ) ){
        				$stopDate = $date;
        				$stopDate->setTime(0, 0, 0);
        			//}
        		}
        	}
        	$answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($user, $this->container->getParameter('combien_de_cigarettes_fumez_vous_par_jour'));
        	foreach ($answers as $answer){
        		$startCigarettes = $answer->getAnswerText();
        	}
        	
        	$tmpCigarettes = $startCigarettes;
        	$tmpWeek = $startWeek;
        	$cigaretteFumee = $tmpCigarettes;
        	
        	$endDate->setTime(0, 0, 0);
        	$startDate->setTime(0, 0, 0);
        	//$date_ = $startDate;
        	$date_ = new \DateTime('now');
        	$date_->setTimestamp( ($stopDate == NULL || $startDate <= $stopDate ) ? $startDate->getTimestamp() : $stopDate->getTimestamp());
        	while ( $date_ <= $endDate ){
        		if( $stopDate == NULL ){ // Phase de contemplation
	        		$tmpCigarettes = $cigaretteFumee;
	        		$cigaretteFumee = ceil($this->getNumberCigarettesByDay($tmpCigarettes, $reduction));
        		}elseif( $date_ < $stopDate ){ // Phase de préparation : Date d'arrêt >= Date d'inscription
        			$Week = $date_->format('W');
        			if( $tmpWeek != $Week ){
        				$tmpWeek = $Week;
        				$tmpCigarettes = $cigaretteFumee;
        			}
        			$cigaretteFumee = ceil($this->getNumberCigarettesByDay($tmpCigarettes, $reduction));
        		}else{// Phase de préparation : Date d'arrêt < Date d'inscription
        			$cigaretteFumee = 0;
        		}
        		$objectif = $startCigarettes - $cigaretteFumee;
        		//echo $tmpCigarettes.'######'.date('Y-m-d', $date_->getTimestamp()).'/'.$cigaretteFumee.'/'.$objectif.'<br/>';
        		$result['cigarettes'] += $stopDate == NULL ? 0:$objectif;
        		$result['objectif_jour'] = $objectif; //$cigaretteFumee;
        		$date_->add(new \DateInterval('P1D'));
        	}
        	$priceCigarette = 0;
        	foreach($user->getPatientEconomys() as $patientEconomy){
        		$priceCigarette = $patientEconomy->getPaquetSize() == 0 ? 0 : $patientEconomy->getPrice() / $patientEconomy->getPaquetSize();
        	}
//        	$result['euros'] = round($result['cigarettes'] * $priceCigarette, 2, PHP_ROUND_HALF_UP);
        	$result['euros'] = ceil($result['cigarettes'] * $priceCigarette);
        	$points = 0;
        	foreach($user->getPointHistories() as $pointHistory){
        		$points += $pointHistory->getNbPoint();
        	}
        	$result['points'] = $points;
        	$badges = array();
        	if( $points >= 100  ){ //$stopDate != NULL
        		$result['badge1'] = true;
        	}
        	if( $points >= 300 && $points < 500){
        		$result['badge2'] = true;
        	}elseif( $points >= 500 && $points < 1500){
        		$result['badge2'] = true;
        		$result['badge3'] = true;
        	}else{
        		if( $points >= 1500 ){
	        		$result['badge2'] = true;
        			$result['badge3'] = true;
	        		
	        		$currentDate = new \DateTime('now');
	        		$currentDate->setTime(0, 0, 0);
	        		$datePoint = new \DateTime('now');
	        		$datePoint->setTime(0, 0, 0);
	        		$datePoint->sub(new \DateInterval('P1M'));
	        		$datePoint2 = new \DateTime('now');
	        		$datePoint2->setTime(0, 0, 0);
	        		$datePoint2->sub(new \DateInterval('P2M'));
	        		$craque = false;
	        		$craque2 = false;
	        		
	        		$answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($user, $this->container->getParameter('avez_vous_pris_un_substitut_nicotinique'));
	        		foreach ($answers as $answer){
	        			$d = $answer->getCreatedAt();
	        			$d->setTime(0, 0, 0);
	        			if( $d >= $datePoint && $d <= $currentDate ){
	        				$craque = true;
	        			}
	        			if( $d >= $datePoint2 && $d <= $currentDate ){
	        				$craque2 = true;
	        			}
	        		}
	        		if( $stopDate != NULL && ($stopDate < $datePoint && $craque == false ) ){
	        			$result['badge4'] = true;
	        		}
	        		if( $points >= 3000 && $stopDate != NULL && ($stopDate < $datePoint2 && $craque2 == false ) ){
		        		$result['badge5'] = true;
		        	}
        		}
        	}
        	
        	
        	if( $stopDate == NULL|| $stopDate > $endDate){
        		$result['sans_tabac_1'] = 0;
        	}else{
        		 $result['sans_tabac_1'] = $endDate->diff($stopDate)->format('%a') + 1;
        	}
        }  
        return $result;
    }
    
    public function getDetailsPoint($token){
    	$user = $this->em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
    	$result = array();
    	$result['points'] = 0;
    	$result['details'] = array();
    	 
    	if ( trim($token) != "" && $user != NULL ) {
    		$startDate = $user->getCreatedAt();
	    	$endDate = new \DateTime('now');
	    	
	    	$stopDate = NULL;
	    	$contratDate = NULL;
	    	foreach($user->getContracts() as $contract){
	    		if( $contract->getStopDate() != NULL ){
	    			$date = $contract->getStopDate();
	    			if( $startDate <= $date && ($stopDate == NULL || $stopDate <= $date ) ){
	    				$stopDate = $date;
	    				$stopDate->setTime(0, 0, 0);
	    				$contratDate = $contract->getCreatedAt();
	    				$contratDate->setTime(0, 0, 0);
	    			}
	    		}
	    	}
	    	/*if( $stopDate != NULL && $stopDate < $endDate ){
	    		$endDate = $stopDate;
	    	}*/
	    	$startDate->setTime(0, 0, 0);
	    	$endDate->setTime(0, 0, 0);
	    	
	    	$points = 0;
	    	$details = array();
    		$date_ = $startDate;
    		$badges = array();
        	while ( $date_ <= $endDate ){
        		$tmpStartDate = new \DateTime($date_->format('Y-m-d 00:00:00'));
        		
        		
        		$date_->add(new \DateInterval('P6D'));        		
        		if( $date_ > $endDate ){
        			$tmpEndDate = new \DateTime($endDate->format('Y-m-d 00:00:00'));
        		}else{
        			$tmpEndDate = new \DateTime($date_->format('Y-m-d 00:00:00'));
        		}
        		$detail = array();
        		$detail['start'] = $tmpStartDate->format('d/m');
        		$detail['badge'] = 0;
        		$detail['end'] = $tmpEndDate->format('d/m');
        		
        		$pointsWeek = 0;
        		$pointHistories = $this->em->getRepository('NicoretteCentralBundle:PointHistory')->getPointsByPatient($user, $tmpStartDate->format('Y-m-d 00:00:00'), $tmpEndDate->format('Y-m-d 23:59:59'));
        		foreach($pointHistories as $pointHistory){
        			$pointsWeek += $pointHistory->getNbPoint();
        		}
        		$points += $pointsWeek;
        		$detail['points'] = $pointsWeek;
        		
        		$details[] = $detail;
        		if( !in_array(1, $badges) && $points >= 100 ){ //&& $contratDate != NULL && $tmpStartDate <= $contratDate && $contratDate <= $tmpEndDate
        			$detail = array();
        			$detail['start'] = $tmpEndDate->format('d/m/Y');
        			$detail['badge'] = 1;
        			$badges[1]=1;
        			$detail['points'] = $points;
        			$details[] = $detail;
        		}
        		
        		if( !in_array(2, $badges) && $points >= 300 && $points < 500){
        			$detail = array();
        			$detail['start'] = $tmpEndDate->format('d/m/Y');
        			$detail['badge'] = 2;
        			$badges[2]=2;
        			$detail['points'] = $points;
        			$details[] = $detail;
        		}
        		if( !in_array(3, $badges) && $points >= 500 && $points < 1500){
        			$detail = array();
        			$detail['start'] = $tmpEndDate->format('d/m/Y');
        			$detail['badge'] = 3;
        			$badges[3]=3;
        			$detail['points'] = $points;
        			$details[] = $detail;        			
        		}
        		if( ( !in_array(4, $badges) || !in_array(4, $badges) ) && $points >= 1500 ){
        				$currentDate = new \DateTime('now');
        				$currentDate->setTime(0, 0, 0);
        				$datePoint = new \DateTime('now');
        				$datePoint->setTime(0, 0, 0);
        				$datePoint->sub(new \DateInterval('P1M'));
        				$datePoint2 = new \DateTime('now');
        				$datePoint2->setTime(0, 0, 0);
        				$datePoint2->sub(new \DateInterval('P2M'));
        				$craque = false;
        				$craque2 = false;
        				 
        				$answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($user, $this->container->getParameter('avez_vous_pris_un_substitut_nicotinique'));
        				foreach ($answers as $answer){
        					$d = $answer->getCreatedAt();
        					$d->setTime(0, 0, 0);
        					if( $d >= $datePoint && $d <= $currentDate ){
        						$craque = true;
        					}
        					if( $d >= $datePoint2 && $d <= $currentDate ){
        						$craque2 = true;
        					}
        				}
        				if( !in_array(4, $badges) && $stopDate != NULL && ($stopDate < $datePoint && $craque == false ) ){
        					$detail = array();
		        			$detail['start'] = $tmpEndDate->format('d/m/Y');
		        			$detail['badge'] = 4;
		        			$badges[4]=4;
		        			$detail['points'] = $points;
		        			$details[] = $detail; 
        				}
        				if( !in_array(5, $badges) && $points >= 3000 && $stopDate != NULL && ($stopDate < $datePoint2 && $craque2 == false ) ){
        					$detail = array();
		        			$detail['start'] = $tmpEndDate->format('d/m/Y');
		        			$detail['badge'] = 5;
		        			$badges[5]=5;
		        			$detail['points'] = $points;
		        			$details[] = $detail; 
        				}
        		}
        		
        		$date_->add(new \DateInterval('P1D'));
        	}
    		
    		$result['points'] = $points;
    		$result['details'] = $details;
    	}
    	return $result;
    }
    
    public function getNumberDayWithoutCigarette($token){
    	$user = $this->em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
    	$result = array();
    	$result['sans_tabac'] = 0;
    	 
    	if ( trim($token) != "" && $user != NULL ) {
    		$startDate = $user->getCreatedAt();
    		$startDate->setTime(0, 0, 0);
    		$endDate = new \DateTime('now');
    		$endDate->setTime(0, 0, 0);
    		$stopDate = NULL;
    		foreach($user->getContracts() as $contract){
    			if( $contract->getStopDate() != NULL ){
    				$date = $contract->getStopDate();
    				//if( $startDate <= $date && ($stopDate == NULL || $stopDate <= $date ) ){
    					$stopDate = $date;
    					$stopDate->setTime(0, 0, 0);
    				//}
    			}
    		}
    		if( $stopDate == NULL|| $stopDate > $endDate){
    			$result['sans_tabac'] = 0;
    		}else{
    			$result['sans_tabac'] = $endDate->diff($stopDate)->format('%a') + 1;
    		}
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