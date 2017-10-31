<?php

namespace Nicorette\ApiBundle\Controller;

use Nicorette\CentralBundle\Entity\Contract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;

/**
 * controlleur pour la gestion des contrat
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class ContractController extends Controller
{

    /**
     * @Post("/contract/lastOne/{engaged}", name="set_last_smoked_cigarette_date", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Ajouter une date de la dernière cigarette fumer",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="lastSmokedon", "dataType"="Date", "required"=true, "description"="Last smoked cigarette date"},
     *      {"name"="angajed", "dataType"="Boolean", "required"=true, "description"="Je m'engaje a ce contrat"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
     * )
     *
     */
    public function lastCigaretteAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $lastSmokedon = $request->get('lastSmokedon');
        $lastSmokedon = new \DateTime($lastSmokedon);
        if ($lastSmokedon) {
            if ($request->get('angajed')) {
                if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))) {

                    $idContract1 = $this->container->getParameter('contract2');
                    $toolsService = $this->get('nicorette.tools');
                    $answers = $toolsService->getUserInitQuizQAnswers($user);
                    if ($answers && isset($answers['choice'])) {
                        $addContract = false;
                        foreach ($idContract1 as $id) {
                            if (in_array($id, $answers['choice'])) {
                                $addContract = true;
                            }
                        }
                            if ($addContract) {
                                $contract = new Contract();
                                $contract->setLastCigarette($lastSmokedon);
                                $contract->setPatient($user);
                                $user->addContract($contract);
                                $em->persist($user);
                                
                                /*add points*/
                                $points=$this->container->getParameter('points');
                                $this->container->get('nicorette.tools')->addUserPoint($user,'contract_create',$points['contract_create'],$em);

                                $em->flush();
                                
                                $result['success'] = true;
                                $result['data']['msg'] = 'Date de la dernière cigarette fumé ajouter avec succès';

                        } else {
                            $result['success'] = false;
                            $result['errors']['url'] = 'contrat/1';
                        }

                    }
                } else {
                    $result['success'] = false;
                    $result['errors'][] = 'Token invalide ou inéxistant';
                }
            } else {
                $result['success'] = false;
                $result['errors'][] = 'Vous n\'ètes pas engager à ce contrat?';
            }
        } else {
            $result['success'] = false;
            $result['errors'][] = 'La date renseigé n\'est pas valide';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Post("/contract/{angajed}", name="set_quit_date", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Ajouter une date d'arrét de fumer",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="quitDate", "dataType"="Date", "required"=true, "description"="Quit date Y-m-d"},
     *      {"name"="angajed", "dataType"="Boolean", "required"=true, "description"="Je m'engaje a ce contrat"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
     * )
     *
     */
    public function quitDateContractAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
//        $quitDate=$request->get('quitDate');
        $quitDate = new \DateTime($request->get('quitDate'));
        $quitDate = $quitDate->format("Y-m-d");
//        $quitDate=date('Y-m-d', strtotime($request->get('quitDate')));
        $today = date("Y-m-d");
        $MaxDate = date('Y-m-d', strtotime($today . ' + 90 days'));
        if ($quitDate && $quitDate >= $today && $MaxDate >= $quitDate) {
            if ($request->get('angajed')) {
                if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))) {

                    $idContract1 = $this->container->getParameter('contract2');
                    $toolsService = $this->get('nicorette.tools');
                    $answers = $toolsService->getUserInitQuizQAnswers($user);
                    if ($answers && isset($answers['choice'])) {
                        $addContract = true;
                        foreach ($idContract1 as $id) {
                            if (in_array($id, $answers['choice'])) {
                                $addContract = false;
                            }
                        }
                        if ($addContract) {
                            $contract = new Contract();
                            $quitDate = new \DateTime($request->get('quitDate'));
                            $contract->setStopDate($quitDate);
                            $contract->setPatient($user);
                            $user->addContract($contract);
                            $em->persist($user);
                            
                            /*add points*/
//                            $toolsService->addPoint('contract_create', $user);

                            $points=$this->container->getParameter('points');
                            $this->container->get('nicorette.tools')->addUserPoint($user,'contract_create',$points['contract_create'],$em);
                            
                            $em->flush();
                            $result['success'] = true;
                            $result['data']['msg'] = 'Date d\'arrét ajouter avec succès';
                        } else {
                            $result['success'] = false;
                            $result['errors']['url'] = 'contrat/2';
                        }

                    }
                } else {
                    $result['success'] = false;
                    $result['errors'][] = 'Token invalide ou inéxistant';
                }
            } else {
                $result['success'] = false;
                $result['errors'][] = 'Vous n\'ètes pas engager à ce contrat?';
            }
        } else {
            $result['success'] = false;
            $result['errors'][] = 'La date renseigé n\'est pas valide';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }


    /**
     * @Post("/quit-program", name="set_quit_program_nicorette", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Mettre fin au programme d'arrét nicorette",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="quit", "dataType"="integer", "required"=true, "description"="Indique si le patient souhaite quitté le programme d'arrét nicorette"},
     *      {"name"="deleteAccount", "dataType"="boolean", "required"=true, "description"="Indique si le patient souhaite supprimer sont compte nicorette ou non"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
     * )
     *
     */
    public function quitProgramAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))){

            $contract = $em->getRepository('NicoretteCentralBundle:Contract')->getLastContractsByUser($user);
            $contract->setQuit($request->get('quit'));
            $em->persist($contract);
            $em->flush();
            $userTools=$this->get('user_tools_service');
            if($request->get('deleteAccount')==true){
                $em->remove($user);
                // supprimer le compte de l'api de janrain
                $userTools->deleteUserFromJanrain($user->getJanrainId());
                $em->flush();
                $result['success'] = true;
                $result['data']['msg'] = 'Votre programme est arrèté avec succès';
            }elseif($request->get('deleteAccount')==false){
                $clonedUser=$userTools->handlyClone($user);
                $em->remove($user);
                $em->flush();
                $em->persist($clonedUser);
                $em->flush();
                $result['success'] = true;
                $result['data']['msg'] = 'Votre programme est arrèté avec succès';
                $result['data']['popUp'] = true;//afficher un pop up pour l'utilisateur "Vous avez mis fin à votre dernière tentative d'arrêt. Souhaitez-vous eassayez à nouveau ?"

            }
        } else{
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inéxistant';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }
    
    /**
     * @Get("/contract/info/date", name="user_get_contract_date", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="get contract date",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getverificationCodeAction(Request $request)
    {
    	$headers = $request->headers;
    	$view = FOSView::create();
    	/*$result['url'] = '/';
    	$view->setStatusCode(401)->setData($result);
    	//var_dump()
    	return $view;*/
    	$em = $this->getDoctrine()->getManager();
    	$tools = $this->get('nicorette.tools');
    	if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))):
    		$contract = $em->getRepository('NicoretteCentralBundle:Contract')->getLastContractsByUser($user);
    		$next = $tools->getContractUrl($user);
    		if($contract){
    			$date = $contract->getStopDate()?$contract->getStopDate():$contract->getLastCigarette();
    			$result['success'] = true;
    			$result['data']['date'] = $date?$date->format('d/m/Y'):'';
	    	}else{
	    		$result['success'] = false;
	    		$result['data']['url'] = $next;
	    	}
	    else:
	    	$result['success'] = false;
	    	$result['errors'][] = 'Token invalide ou inéxistant';
	    endif;
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }

    /**
     * @Get("/quit-nicorette-program/{token}", name="get_quiz_quit_program_", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="récupérer les questions de 'quitter mon programme'",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getQuitAction(Request $request,$token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $code=$this->container->getParameter('quit_program_code');
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if($quiz){
            if($user){
                $result['success'] = true;
                $result['data']['quiz'] = $quiz;
            }else{
                $result['success'] = false;
                $result['errors'][] = 'Token invalide';
            }
        }else{
            $result['success'] = false;
            $result['errors'][] = 'Code Quiz invalide ou inéxistant';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }

}
