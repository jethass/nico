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
 * Contrôleur pour la gestion de journal avant et après la fixation de la date d'arrêt
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class DiaryController extends Controller
{

    /**
     * @Get("/diary/access-control/{token}", name="access_control_to_diary", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Contrôler l'accès au url déja saisis dans la barre d'addresse relative à mon journal before ou after .",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"},
     *      {"name"="diary", "dataType"="string", "required"=false, "description"="paramètre renseignant le type de mon journal 'before' ou 'after'"}
     *  }
     * )
     *
     */
    public function accessControlAction(Request $request,$token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        $contracts = $user->getContracts();
        $today = new \DateTime('today');
        $today = $today->format('Y-m-d');
        if (count($contracts) > 0 && $contracts[0]) {
            $stopDate = $contracts[0]->getStopDate();
            if ($stopDate->format('Y-m-d') >= $today && strtolower($request->get('diary')) =='before' || $stopDate->format('Y-m-d') < $today && strtolower($request->get('diary')) =='after')
                $result['url'] = true;
            else
                $result['url'] = false;
        } elseif(strtolower($request->get('diary')) =='before')//date d'arret non fixée
            $result['url'] = true;
        else
            $result['url'] = false;
        $view->setStatusCode(200)->setData($result);
        return $view;
    }
    /**
     * @Get("/diary/switch/{token}", name="switch_me_to_diary", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer l'url de redirection vers mon journal before ou after.",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function diaryUrlSwitchAction($token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if($user) {
            $contracts = $user->getContracts();
            $today = new \DateTime('today');
            $today = $today->format('Y-m-d');
            if (count($contracts) > 0 && $contracts[0]) {
                $stopDate = $contracts[0]->getStopDate();
                if ( $stopDate!= null && $stopDate->format('Y-m-d') >= $today)
                    $result['url'] = 'before';
                else
                    $result['url'] = 'after';
            } else
                $result['url'] = 'before';//date d'arret non fixée
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Token invalide, you need reconnection';
            $result['redirectUrl'][] = '/';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Get("/diary/before/{token}", name="get_my_diary_before_quit", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer les questions et réponses de mon journal avant la date d'arrêt avec ces retours spécifiques nécessaires",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getMyDiaryBeforeAction(Request $request, $token)
    {
        $code = $this->container->getParameter('my_diary_before_quit_code');
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if ($quiz) {
            if ($user) {
                $contracts = $user->getContracts();
                $today = new \DateTime('today');
                $today = $today->format('Y-m-d');
                if ((count($contracts) > 0 && $contracts[0] && $contracts[0]->getStopDate()!= null && $contracts[0]->getStopDate()->format('Y-m-d') >= $today)||count($contracts) ==
                    0) {
                    $result['success'] = true;
                    $result['data']['quiz'] = $quiz;
                    if ($token && $user):
                        $answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
                        $result['data']['answers'] = $answers;
                    endif;
                    // ajouter a result la partie specifique pour le retour de quiz Mon Journal(Lot 2 Mon journal after point 1 et 3 dans le moc)
                    $myDiaryService = $this->get('nicorette.diary_service');

                    $questionId = $this->container->getParameter('first_question_my_diary_before_id');
                    $result['data']['dayObjective'] = $myDiaryService->getDayObjectiveBefore($user, $quiz);//retourne le nombre de cigarette comme objectif du jour
                    $result['data']['isInsertedToday'] = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'boolean', $questionId);//retourne si le journal est remplis ce jour la
                    $result['data']['lastAnswers']['firstQuestion']['idAnswer'] = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'idAnswer', $questionId);//retourne l'id de la réponse de la premiere question si elle existe du jour courant
                    $result['data']['lastAnswers']['firstQuestion']['idChoice'] = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'idChoice', $questionId);//retourne l'id du choix de la premiere question si elle existe du jour courant
                    $result['data']['lastAnswers']['firstQuestion']['value'] = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'value', $questionId);//retourne la valeur saisis pour la premiere question du jour courant

                    $questionId = $this->container->getParameter('second_question_my_diary_before_id');
                    $result['data']['lastAnswers']['secondQuestion']['idAnswer'] = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'idAnswer', $questionId);//retourne l'id de la réponse de la deuxième question si elle existe du jour courant
                    $result['data']['lastAnswers']['secondQuestion']['idChoice'] = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'idChoice', $questionId);//retourne l'id du choix de la deuxième question si elle existe du jour courant
                    $result['data']['lastAnswers']['secondQuestion']['value'] = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'value', $questionId);//retourne la valeur saisis pour la deuxième question du jour courant
                } else {
                    $result['success'] = false;
                    $result['redirectUrl'][] = 'after';//$request->getSchemeAndHttpHost() . $this->generateUrl('get_my_diary_after_quit', array('token' => $token));
                }

            } else {
                $result['success'] = false;
                $result['errors'][] = 'Token invalide, you need reconnection';
                $result['redirectUrl'][] = '/';
            }
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Code Quiz invalide ou inexistant, veuillez vérifier le code dans la base.';
        }


        $view->setStatusCode(200)->setData($result);
        return $view;
    }


    /**
     * @Get("/diary/after/first/{token}", name="get_my_diary_after_quit_first_question_", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer la premiere question et réponses de mon journal après la date d'arrêt avec ces retours spécifiques nécessaires",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function fQMyDiaryAfterAction(Request $request, $token)
    {
        $code = $this->container->getParameter('my_diary_after_quit_code');
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if ($quiz) {
            if ($user) {
                $contracts = $user->getContracts();
                $today = new \DateTime('today');
                $today = $today->format('Y-m-d');
                if (count($contracts) > 0 && $contracts[0] && $contracts[0]->getStopDate()!= null && $contracts[0]->getStopDate()->format('Y-m-d') < $today) {
                    $result['success'] = true;
                    $result['data']['quiz'] = $quiz;
                    if ($token && $user):
                        $answers = $em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
                        $result['data']['answers'] = $answers;
                    endif;
                    // ajouter a result la partie specifique pour le retour de quiz Mon Journal(Lot 2 Mon journal after point 1 et 3 dans le moc)
                    $myDiaryService = $this->get('nicorette.diary_service');
                    $questionId = $this->container->getParameter('first_question_my_diary_after_id');
                    $result['data']['knownByDoctor'] = $myDiaryService->isKnownByDoctor($user);//retourne si l'utilisateur à connue l'application par son docteur ou nn
                    $result['data']['lastDifficulty'] = $myDiaryService->getLastDifficutiLevelAfter($user, $quiz, $questionId);//retourne la derniere difficulté renseignée
                    $result['data']['averageDifficulty'] = $myDiaryService->getAverageDifficutyAfter($user, $quiz, 'average', $questionId);// retourne la moyenne de 7 dernieres difficulter renseigner
                    $result['data']['countInsertedAnswers'] = $myDiaryService->getAverageDifficutyAfter($user, $quiz, 'countAnswers', $questionId);// retourne la moyenne de 7 dernieres difficulter renseigner
                    $result['data']['isInsertedToday'] = $myDiaryService->isInsertedTodayAfter($user, $quiz, $return = 'boolean', $questionId);//retourne si le journal est remplis ce jour la

                    $result['data']['lastAnswers']['idAnswer'] = $myDiaryService->isInsertedTodayAfter($user, $quiz, $return = 'idAnswer', $questionId);//retourne l'id de la réponse de la premiere question si elle existe du jour courant
                    $result['data']['lastAnswers']['idChoice'] = $myDiaryService->isInsertedTodayAfter($user, $quiz, $return = 'idChoice', $questionId);//retourne l'id du choix de la premiere question si elle existe du jour courant
                    $result['data']['lastAnswers']['value'] = $myDiaryService->isInsertedTodayAfter($user, $quiz, $return = 'value', $questionId);//retourne la valeur saisis pour la premiere question du jour courant

                } else {
                    $result['success'] = false;
                    $result['redirectUrl'][] = 'before';//$request->getSchemeAndHttpHost().$this->generateUrl('get_my_diary_after_quit', array('token' => $token));
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
     * @Get("/diary/after/second/{token}", name="get_my_diary_after_quit_second_question_", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer la deuxieme question et réponses de mon journal après la date d'arrêt avec ces retours spécifiques nécessaires",
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

}
