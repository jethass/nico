<?php

namespace Nicorette\ApiBundle\Controller;

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
use Nicorette\CentralBundle\Entity\QuizAnswer;

class AnswersController extends Controller
{

	/**
	 * @Post("/answers/{code}", name="set_answers_for_quiz", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="Enrégistrer les réponses d'un utilisateur s'il est connecté",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
	 *      {"name"="code", "dataType"="string", "required"=true, "description"="Code Quiz"},
	 *      {"name"="answers", "dataType"="array", "required"=true, "description"="Réponses quiz"},
	 *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
	 *  },
     *  output="['success'] = true si tout est valide ou ['success'] = false avec un message descriptif sur le traitement."
	 * )
	 *
	 */
	public function postAnswersAction(Request $request, $code)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);
    	$initQuizes = array('FEEDBACK_1', 'FEEDBACK_2', 'FEEDBACK_3');
    	$tools = $this->get('nicorette.tools');
    	$points = $this->container->getParameter('points');
    	
    	/*save answers in session*/
    	$session = $this->get('nicorette.session');
    	$session->setFeedbackAnswers($code, $request->get('answers'));
    	
    	/*calculate score ans get feedback*/
    	$score = $tools->getFeedbackByScore($code, $request->get('answers'));
    	
    	if( !array_key_exists('profil_2', $score) ){
    		$score['profil_2']="";
    	}
    	
    	if($quiz):
    		if($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))):
    			if(in_array($code, $initQuizes ) ){
    				$quizAnswer = $em->getRepository('NicoretteCentralBundle:QuizAnswer')->findOneBy(array('patient' => $user,'quiz'=> $quiz));
    				if(!$quizAnswer){
    					$quizAnswer = new QuizAnswer();
    					$quizAnswer->setData($quiz, $user);
    					$em->persist($quizAnswer);
    					$em->flush();
    					$session->saveFeedbackAnswers($code, $quizAnswer, $user, $points);
    				}
    			}else{
    				$quizAnswer = new QuizAnswer();
    			}
    		endif;
    		$result['success'] = true;
    		$result['data']['score'] = $score;
    	else:
    		$result['success'] = false;
    		$result['errors'][] = 'Code Quiz invalide ou inéxistant';
    	endif;
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
    
    /**
     * @Post("/initquiz/answers/save", name="save_answers_for_initquiz", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Enrégistrer les réponses d'un utilisateur s'il n'est pas connecté et redirection",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  },
     *  output="['success'] = true si tout est valide ou ['success'] = false avec un message descriptif sur le traitement."
     * )
     *
     */
    public function saveAnswersAction(Request $request)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$tools = $this->get('nicorette.tools');
    	$points = $this->container->getParameter('points');
    	/*save answers in session*/
    	$session = $this->get('nicorette.session');
    	 
    	if($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))){
    			$data = $session->saveAllFeedbackAnswers($user, $points);
    			if($data){
    				$url = $tools->getUserCurrentStep($user);
    				$result['success'] = true;
    				$result['data']['url'] = $url;
    			}else{
    				$result['success'] = false;
    				$result['errors'][] = 'Une erreur inconnu est survenue ! Veuillez réessayer';
    			}
    	}else{
    		$result['success'] = true;
    		$result['data']['url'] = 'pre-inscription';
    	}
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
    
    
    
}
