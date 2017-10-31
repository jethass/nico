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

class QuizesController extends Controller
{
	
	private static $init_question = array('FEEDBACK_1', 'FEEDBACK_2', 'FEEDBACK_3');

	/**
	 * @Get("/quiz/{code}", name="get_quiz_by_code", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="récupérer les questions et réponses d'un quiz",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
	 *      {"name"="code", "dataType"="string", "required"=true, "description"="Code Quiz"},
	 *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
	 *  }
	 * )
	 *
	 */
	public function getQuizeAction(Request $request, $code)
    {
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);
    	
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'));
    	if($quiz){
    		if($user || in_array($code, self::$init_question)){
	    		$result['success'] = true;
	    		$result['data']['quiz'] = $quiz;
	    		if($request->get('token') && $user):
	    			$answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
	    			$result['data']['answers'] = $answers;
	    		endif;
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
