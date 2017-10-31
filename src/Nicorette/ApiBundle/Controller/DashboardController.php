<?php

namespace Nicorette\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;

class DashboardController extends Controller
{
	

	/**
	 * @Get("/dashboard", name="dashboard")
	 * @ApiDoc(
	 *  description="récupérer les informations dans la page dashboard",
	 *  parameters={
	 *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
	 *  }
	 * )
	 *
	 */
	public function getDashboardAction(Request $request)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$userTools = $this->get('user_tools_service');
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'));
    	
    	if($user){
    		$profile = $userTools->getProfile($user->getJanrainId());
	    	$result['success'] = true;
	    	$economy_service = $this->get('nicorette.economy_service');
	    	$res = $economy_service->getNumberCigarettesEconomy($user->getToken());
	    	
	    	//$data = array('points' => '500', 'cigarette_eco' => '7', 'amount_eco' => '20' , 'day_objectif' => '3', 'nbr_day_without_cigarette' => '5', 'contract' => true,'sex_in_quiz' => 'MR'); /*TODO*/
	    	$data = array('points' => $res["points"], 
	    				   'cigarette_eco' => $res["cigarettes"],
	    			       'amount_eco' => $res["euros"] , 
	    			       'day_objectif' => $res["objectif_jour"], 
	    			       'badge1' => $res["badge1"], 
	    				   'badge2' => $res["badge2"],
	    			       'badge3' => $res["badge3"], 
	    				   'badge4' => $res["badge4"],
	    			       'badge5' => $res["badge5"], 
	    			       'nbr_day_without_cigarette' => $res["sans_tabac_1"], 
	    			       'nbr_day_without_cigarette2' => $res["sans_tabac_2"], 
	    			       'contract' => true,
	    			       'sex_in_quiz' => $profile['civility'], /*TODO*/
	    			       'picture' => $profile['picture']
	    			); 
	    	
	    	$result['data'] = $data;
    	}else{
    		$result['success'] = false;
    		$result['errors'][] = 'Token invalide';
    	}
    	
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
    
    /**
     * @Get("/statistic", name="statistic")
     * @ApiDoc(
     *  description="Statistique",
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getStatisticAction(Request $request)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	 
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'));
    	if($user){
    		$result['success'] = true;
    		$statistic_service = $this->get('nicorette.statistic_service');
    		$res = $statistic_service->getData($user->getToken());
    
    		$data = array('temptation' => $res["temptation"], 
    						'cracked' => $res["cracked"], 
    						'dangerous' => $res["dangerous"] , 
    						'risky' => $res["risky"]);
    
    		$result['data'] = $data;

            $lastPoint=$em->getRepository('NicoretteCentralBundle:PointHistory')->getLastPointAddedForToday($type='statistic_consultation',$user);
            if(!$lastPoint){
                $points=$this->container->getParameter('points');
                $this->container->get('nicorette.tools')->addUserPoint($user,'statistic_consultation',$points['statistic_consultation'],$em);
            }

    	}else{
    		$result['success'] = false;
    		$result['errors'][] = 'Token invalide';
    	}
    	 
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
    
    /**
     * @Get("/withoutcigarette/{token}", name="number_day_without_cigarette", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="récupérer le nombre de jour sans tabac",
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getNumberDayWithoutCigaretteAction(Request $request)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'));
    	 
    	if($user){
    		$result['success'] = true;
    		$economy_service = $this->get('nicorette.economy_service');
    		$res = $economy_service->getNumberDayWithoutCigarette($user->getToken());
    
    		$data = array('nbr_day_without_cigarette' => $res["sans_tabac"]);
    
    		$result['data'] = $data;
    	}else{
    		$result['success'] = false;
    		$result['errors'][] = 'Token invalide';
    	}
    	 
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
    
    
    /**
     * @Get("/has_doctor", name="get_has_doctor", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer s'il a répondu médecin ou pharmacien",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function hasDoctorAction(Request $request)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'));
    	if ($user) {
    		$myPlanService = $this->get('nicorette.plan_service');
    		$result['success'] = true;
    		$result['data']['isKnownByDoctor'] = $myPlanService->isKnownByDoctor($user);//retourne le nombre de cigarette comme objectif du jour   +++++
    	} else {
    		$result['success'] = false;
    		$result['errors'][] = 'Token invalide';
    	}
    
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
}
