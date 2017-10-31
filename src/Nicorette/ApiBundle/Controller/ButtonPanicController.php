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


/**
 * Contrôleur pour la gestion des boutons Panique
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */

class ButtonPanicController extends Controller
{

	/**
	 * @Get("/panic/want/{token}", name="get_my_panic_button_want", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="Récupérer les questions et réponses de bouton Panic",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
	 *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
	 *  }
	 * )
	 *
	 */
	public function getPanicButtonWantAction(Request $request,$token)
    {
        $code=$this->container->getParameter('panic_button_want_code');
    	$view = FOSView::create();
    	$em = $this->getDoctrine()->getManager();
    	$quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);
    	
    	$user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if ($quiz) {
            if ($user) {
                $result['success'] = true;
                $result['data']['quiz'] = $quiz;
                if ($token && $user):
                    $answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
                    $result['data']['answers'] = $answers;
                endif;
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
     * @Get("/panic/cracked/first/{token}", name="get_my_panic_button_cracked", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer les questions et réponses de bouton zut j'ai craqué",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getPanicButtonCrackedAction(Request $request,$token)
    {
    	$code=$this->container->getParameter('panic_button_cracked_code');
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if ($quiz) {
            if ($user) {
                $result['success'] = true;
                $result['data']['quiz'] = $quiz;
                if ($token && $user):
                    $answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
                    $result['data']['answers'] = $answers;
                endif;
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
     * @Get("/panic/cracked/third/{token}", name="get_my_panic_button_cracked_third_question", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer la troisième question et réponses de bouton zut j'ai craqué",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function sQMyDiaryAfterAction(Request $request, $token)
    {
        $code = $this->container->getParameter('nicotinic_product_code');
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if ($quiz) {
            if ($user) {
                    $result['success'] = true;
                    $result['data']['quiz'] = $quiz;
                    if ($token && $user):
                        $answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
                        $result['data']['answers'] = $answers;
                    endif;
                    // ajouter a result la partie specifique pour le retour de quiz Mon Journal(Lot 2 Mon journal after point 1 et 3 dans le moc)
                    $myDiaryService = $this->get('nicorette.diary_service');
                    // l'idée est de suelement faire apparettre la valeur de la réponse la plus recente avec son id
                    $questionId = $this->container->getParameter('first_question_nicotinic_product_id');
                    $result['data']['lastAnswers']['idAnswer'] = $myDiaryService->isInsertedTodayAfter($user, $quiz, $return = 'idAnswer', $questionId);//retourne l'id de la réponse de la deuxième question si elle existe du jour courant
                    $result['data']['lastAnswers']['idChoice'] = $myDiaryService->isInsertedTodayAfter($user, $quiz, $return = 'idChoice', $questionId);//retourne l'id du choix de la deuxième question si elle existe du jour courant
                    $result['data']['lastAnswers']['value'] = $myDiaryService->isInsertedTodayAfter($user, $quiz, $return = 'value', $questionId);//retourne la valeur saisis pour la deuxième question du jour courant


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
     * @Get("/panic/not-cracked/{token}", name="get_my_panic_button_not_cracked", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer les questions et réponses de bouton zut j'ai tenté mais je n’ai pas craqué",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getPanicButtonNotCrackedAction(Request $request,$token)
    {
        $code=$this->container->getParameter('panic_button_not_cracked_code');
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if ($quiz) {
            if ($user) {
                $result['success'] = true;
                $result['data']['quiz'] = $quiz;
                if ($token && $user):
                    $answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
                    $result['data']['answers'] = $answers;
                endif;
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
    
}
