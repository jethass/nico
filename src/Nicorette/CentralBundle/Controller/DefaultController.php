<?php

namespace Nicorette\CentralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
//     	$mypoints_service = $this->get('nicorette.economy_service');
//     	$res = $mypoints_service->getDetailsPoint("36whe3st2g3t6w6c");
//     	var_dump($res);
    	
    	$calendar_service = $this->get('nicorette.calendar_service');
    	$res = $calendar_service->getData("qdhnmaqkfqvdzcmy");
    	var_dump($res);
    	
//     	$economy_service = $this->get('nicorette.economy_service');
//     	$res = $economy_service->getNumberCigarettesEconomy("bvpv9skv5zmfr8sa");
//     	var_dump($res);
    	
//     	$statistic_service = $this->get('nicorette.statistic_service');
//     	$res = $statistic_service->getData("bvpv9skv5zmfr8sa");
//    	var_dump($res);
    	
    	return array('name' => $name);
    }
}
