<?php

namespace Nicorette\ApiBundle\Controller;

use Nicorette\CentralBundle\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;


/**
 * controlleur pour la gestion du plan d'action du patient
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */

class MyPlanController extends Controller
{

	/**
	 * @Get("/plan", name="get_my_current_action_plan", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="Récupérer les questions et réponses de mon plan d'action avec les reponses déja coché s'il y on a",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
	 *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
	 *  }
	 * )
	 *
	 */
	public function getCurrentPlanAction(Request $request)
    {
        $code=$this->container->getParameter('action_plan_code');
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);
    	
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'));
        if ($quiz) {
            if ($user) {
                $myPlanService = $this->get('nicorette.plan_service');
                $result['success'] = true;
                $question_id=$this->container->getParameter('first_question_feedback_1');
                $answers=$em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($user, $question_id);
                $choiceId= $answers && $answers[0]&& $answers[0]->getChoiceId() ?$answers[0]->getChoiceId():0;
                $afterAdaption=$myPlanService->adaptQuizQuestions($quiz,$user,$choiceId);
                $result['data']['quiz'] = $afterAdaption['quiz'];
                if ($request->get('token') && $user):
                    $answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
                    //récupérer le réponses sur mon plan deja exixtant pour les afficher et les modifiers
                    $result['data']['answers'] = $em->getRepository('NicoretteCentralBundle:QuizAnswer')->findlastAnswerQuizByPatientAndCode($user, $code);
//                    $result['data']['answers'] = $myPlanService->getLastAnswers($quiz,$user,$questionsIds=$afterAdaption['answersForQuestion']);
                endif;
                // ajouter a result la partie specifique pour le retour de quiz Mon Journal(Lot 2 Mon journal after point 1 et 3 dans le moc)
                $result['data']['isKnownByDoctor'] = $myPlanService->isKnownByDoctor($user);//retourne si l'utilisateur a connu l'appli de son docteur ou de son pharmacien
                $result['data']['scoreFager'] = $myPlanService->getFagerScoreByUser($user,$quiz);//retourne le score fager d'un patient  +++++++++++
                $result['data']['recognizedProduct'] = $myPlanService->getRecognizedProduct($user,$result['data']['scoreFager']);//retourne le produit qui s'adapte au patient selon ces réponce "consulter le fichier excel"   ++++++
//                ajouter une somme de point relier a la consultation de mon plan d'action
                $lastPoint=$em->getRepository('NicoretteCentralBundle:PointHistory')->getLastPointAddedForToday('action_plan_consultation',$user);
                if(!$lastPoint){
                    $points=$this->container->getParameter('points');
                    $this->container->get('nicorette.tools')->addUserPoint($user,'action_plan_consultation',$points['action_plan_consultation'],$em);
                }



            } else {
                $result['success'] = false;
                $result['errors'][] = 'Token invalide';
            }
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Code Quiz invalide ou inexistant, veuillez vérifier le code dans la base.';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }
    
    
    /**
     * @Get("/plan/access", name="access_action_plan", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="vérifier l'accès au plan d'action",
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function accessPlanAction(Request $request)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$tools = $this->get('nicorette.tools');
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'));
    	if($user){
    		$contract = $em->getRepository('NicoretteCentralBundle:Contract')->getLastContractsByUser($user);
    		if($contract){
    			$date = $contract->getStopDate()?$contract->getStopDate():$contract->getLastCigarette();
    			$result['success'] = true;
    			$result['data']['date'] = $date?$date->format('d/m/Y'):'';
    		}else{
    			$result['success'] = false;
    			$result['data']['contraturl'] = $tools->getNotFixContrat($user);
    			$result['data']['fixlater'] = $user->getFixLater();
    			if($tools->getUserCurrentStep($user) == 'quiz/FEEDBACK_1' || $tools->getUserCurrentStep($user) == 'quiz/FEEDBACK_2' || $tools->getUserCurrentStep($user) == 'quiz/FEEDBACK_3')
    				$result['feedbackUrl'] = $tools->getUserCurrentStep($user);
    		}
    	}else{
    		$result['success'] = false;
    		$result['errors'][] = 'Token invalide';
    	}
    
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
}
