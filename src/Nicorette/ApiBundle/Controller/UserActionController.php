<?php

namespace Nicorette\ApiBundle\Controller;

use Nicorette\CentralBundle\Entity\PointHistory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View AS FOSView;
use Nicorette\CentralBundle\Entity\QuizAnswer;

/**
 * controlleur pour la sauvegarde des réponses des utilisateurs pour les pages
 * mon journal, mon plan, les bouttons panic, zut j'ai cracké ,help et zut j'ai pas cracké
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class UserActionController extends Controller
{

    /**
     * @Post("/extra_quiz/answers/save/{code}", name="save_answers_for_extra_quiz", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Enrégistrer les réponses d'un utilisateur connecté pour les actions 'Button panique, Zut j'ai cracké et zut j'ai tenter '",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="code", "dataType"="string", "required"=true, "description"="Code Quiz"},
     *      {"name"="answers", "dataType"="array", "required"=true, "description"="Réponses quiz"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function saveExtraAnswerAction(Request $request, $code)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);
        $initQuizes = array($this->container->getParameter('panic_button_not_cracked_code'), $this->container->getParameter('quit_program_code'), $this->container->getParameter('panic_button_want_code'), $this->container->getParameter('panic_button_cracked_code'), $this->container->getParameter('nicotinic_product_code'));

        if ($quiz) {
            $tools = $this->get('nicorette.zut_tools');
            if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))) {
                if (in_array($code, $initQuizes)) {
                    $tools->saveUserAnswers($request->get('answers'), $user, $quiz);
                    $points = $this->container->getParameter('points');
                    switch ($code) {//
                        case $this->container->getParameter('panic_button_not_cracked_code'):
                            $this->container->get('nicorette.tools')->addUserPoint($user, 'not_cracked_form', $points['not_cracked_form'], $em);
                            break;
                        case $this->container->getParameter('panic_button_want_code'):
                            $this->container->get('nicorette.tools')->addUserPoint($user, 'panic_button_want_code', $points['panic_button_want_code'], $em);
                            break;
                        case $this->container->getParameter('panic_button_cracked_code'):
                            $this->container->get('nicorette.tools')->addUserPoint($user, 'cracked_form', $points['cracked_form'], $em);
                            break;
                    }
                } else {
                    $result['success'] = false;
                    $result['errors'][] = 'Code Quiz invalide ou inéxistant pour ce web service';
                }
            } else {
                $result['success'] = false;
                $result['errors'][] = 'Token invalide ou inexistant.';
            }
            $result['success'] = true;
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Code Quiz invalide ou inéxistant';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }


    /**
     * @Post("/diary/answers/save/{code}", name="save_answers_for_diary_", options={ "method_prefix" = false })
     * @ApiDoc(
     *  tags={"stable"},
     *  statusCodes={200="Returned when successful",},
     *  description="Enrégistrer les réponses d'un utilisateur connecté pour les actions 'Mon journal avant et apret la date d'arrét'",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="code", "dataType"="string", "required"=true, "description"="Code Quiz"},
     *      {"name"="method", "dataType"="string", "required"=true, "description"="La méthode à éxécuter 'POST pour l'ajout' et 'PUT pour la mise à jour'"},
     *      {"name"="answers", "dataType"="array", "required"=true, "description"="Réponses quiz"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function saveDiaryAnswersAction(Request $request, $code)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);
        $initQuizes = array($this->container->getParameter('my_diary_before_quit_code'), $this->container->getParameter('nicotinic_product_code'), $this->container->getParameter('my_diary_after_quit_code'));
        $tools = $this->get('nicorette.diary_service');

        if ($quiz) {
            if (in_array($code, $initQuizes)) {
                if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))) {
                    if ($code == $this->container->getParameter('my_diary_before_quit_code')) {
                        //determiner l'action a faire si c'est un ajout ou une modification pour le code "MYDIARY_BEFOREQUIT"
                        if (strtolower($request->get('method')) == 'post') {
                            if ($tools->addUserAnswers($request->get('answers'), $user, $quiz)) {
                                $result['success'] = true;
                                //addScore if user answer is yes for first question, rp: if methos== post then it's the firt answer for current day
                                $this->addPointToUser($code, $user, $request->get('answers'), $em);
                            } else
                                $result['success'] = false;
                        } elseif (strtolower($request->get('method')) == 'put') {
                            $this->mergeUserPoint($code, $user, $request->get('answers'), $em, $quiz);
                            if ($tools->mergeUserAnswers($request->get('answers'))) {
                                $result['success'] = true;
                            } else {
                                $result['success'] = false;
                                $result['errors'][] = 'Mise à jours impossible.';
                            }
                        }
                    } elseif ($code == $this->container->getParameter('my_diary_after_quit_code')) {
                        //determiner l'action a faire si c'est un ajout ou une modification pour le code "MYDIARY_AFTERQUIT"
                        if (strtolower($request->get('method')) == 'post') {
                            if ($tools->addUserAnswers($request->get('answers'), $user, $quiz)) {
                                $result['success'] = true;
                            } else {
                                $result['success'] = false;
                                $result['errors'][] = 'Mise à jours impossible.';
                            }
                        } elseif (strtolower($request->get('method')) == 'put') {
                            if ($tools->mergeUserAnswers($request->get('answers'))) {
                                $result['success'] = true;
                            } else {
                                $result['success'] = false;
                                $result['errors'][] = 'Mise à jours impossible.';
                            }
                        }
                    } elseif ($code == $this->container->getParameter('nicotinic_product_code')) {
                        //determiner l'action a faire si c'est un ajout ou une modification pour le code "NICOTINIC_PRODUCT"
                        if (strtolower($request->get('method')) == 'post') {
                            if ($tools->addUserAnswers($request->get('answers'), $user, $quiz)) {
                                $result['success'] = true;
                            } else {
                                $result['success'] = false;
                                $result['errors'][] = 'Mise à jours impossible.';
                            }
                        } elseif (strtolower($request->get('method')) == 'put') {
                            if ($tools->mergeUserAnswers($request->get('answers'))) {
                                $result['success'] = true;
                            } else {
                                $result['success'] = false;
                                $result['errors'][] = 'Mise à jours impossible.';
                            }
                        }
                    }
                } else {
                    $result['success'] = false;
                    $result['errors'][] = 'Token invalide ou inexistant.';
                }
            } else {
                $result['success'] = false;
                $result['errors'][] = 'Code Quiz invalide ou inéxistant pour ce web service';
            }

            $result['success'] = true;
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Code Quiz invalide ou inéxistant';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    public function addPointToUser($code, $user, $answers, $em)
    {
        $yesNoChoice = $em->getRepository('NicoretteCentralBundle:Choice')->findOneById($answers[0]['idChoice']);
        $yesNoChoice = strtolower($yesNoChoice->getName());
        if ($code == $this->container->getParameter('my_diary_before_quit_code') && $yesNoChoice == 'oui') {
            $points = $this->container->getParameter('points');
            $this->container->get('nicorette.tools')->addUserPoint($user, 'goal_achieved', $points['goal_achieved'], $em);
        }
    }

    public function mergeUserPoint($code, $user, $answers, $em, $quiz)
    {
        $myDiaryService = $this->get('nicorette.diary_service');
        $questionId = $this->container->getParameter('first_question_my_diary_before_id');
        //récupérer la derniere réponse pour la question first_question_my_diary_before
//        $idCoiceOflastAnswer=$myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'idChoice',$questionId);//retourne l'id du choix de la premiere question si elle existe du jour courant
        $valueChoiceOflastAnswer = $myDiaryService->isInsertedTodayBefore($user, $quiz, $return = 'value', $questionId);//retourne la valeur saisis pour la premiere question du jour courant

        $yesNoChoice = $em->getRepository('NicoretteCentralBundle:Choice')->findOneById($answers[0]['idChoice']);
        $yesNoChoice = strtolower($yesNoChoice->getName());
        if ($code == $this->container->getParameter('my_diary_before_quit_code') && $yesNoChoice == 'oui' && strtolower($valueChoiceOflastAnswer) == 'non') {
            $points = $this->container->getParameter('points');
            $this->container->get('nicorette.tools')->addUserPoint($user, 'goal_achieved', $points['goal_achieved'], $em);

        } elseif ($code == $this->container->getParameter('my_diary_before_quit_code') && $yesNoChoice == 'non' && strtolower($valueChoiceOflastAnswer) == 'oui') {
//            getlast 4point added for today where type == goal_achieved
            $today = new \DateTime('today');
//            $today=$today->format('Y-m-d');
            $point = $em->getRepository('NicoretteCentralBundle:PointHistory')->getLastPointAddedForToday('goal_achieved', $user, $today);
            if ($point) {
//                in this case we soustract 4 point
                $patient = $point->getPatient();
                $patient->removePointHistory($point);
                $em->Persist($patient);
                $em->remove($point);
                $em->flush();
            }
        }
    }

    /**
     * @Post("/plan/answers/save/{code}", name="_save_my_plan_answers_", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Enrégistrer les réponses d'un utilisateur connecté pour le action mon plan",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="code", "dataType"="string", "required"=true, "description"="Code Quiz"},
     *      {"name"="answers", "dataType"="array", "required"=true, "description"="Réponses quiz"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function savePlanAnswerAction(Request $request, $code)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($code);
//        $initQuizes = array($this->container->getParameter('action_plan_code'));

        if ($quiz) {
            $tools = $this->get('nicorette.zut_tools');
            if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))) {
//                if (in_array($code, $initQuizes)) {
                $tools->saveUserAnswers($request->get('answers'), $user, $quiz);
//                } else {
//                    $result['success'] = false;
//                    $result['errors'][] = 'Code Quiz invalide ou inéxistant pour ce web service';
//                }
            } else {
                $result['success'] = false;
                $result['errors'][] = 'Token invalide ou inexistant.';
            }
            $result['success'] = true;
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Code Quiz invalide ou inéxistant';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Post("/patient/add-extra-point", name="add_extra_point_", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Enrégistrer les réponses d'un utilisateur connecté pour le action mon plan",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="type", "dataType"="string", "required"=true, "description"="type d'ajout des point"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function addExtraPointAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if ($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))) {
            $points = $this->container->getParameter('points');
            $lastPoint = $em->getRepository('NicoretteCentralBundle:PointHistory')->getLastPointAddedForToday($request->get('type'), $user);
            switch (strtolower($request->get('type'))) {
                case 'new_game_consultation': {//ajouter les points juste une fois par jour
                    if (!$lastPoint) {
                        $this->container->get('nicorette.tools')->addUserPoint($user, $request->get('type'), $points[$request->get('type')], $em);
                    }break;
                }
                case 'actuality_site_consultation': {//ajouter les points juste une fois par jour
                    if (!$lastPoint) {
                        $this->container->get('nicorette.tools')->addUserPoint($user, $request->get('type'), $points[$request->get('type')], $em);
                    }break;
                }
                case 'call_parrain': {//ajouter les points juste une fois par jour
                        $this->container->get('nicorette.tools')->addUserPoint($user, $request->get('type'), $points[$request->get('type')], $em);break;
                }
                case 'send_message': {//ajouter les points juste une fois par jour
                        $this->container->get('nicorette.tools')->addUserPoint($user, $request->get('type'), $points[$request->get('type')], $em);break;
                }
                case strpos($request->get('type'), 'trick'): {//on ajoute un point par astuce
                    if ( !$lastPoint) {
                        $this->container->get('nicorette.tools')->addUserPoint($user, $request->get('type'), $points['tricks_consultation'], $em);
                    }break;
                }
            }
            $result['success'] = true;
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inexistant.';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

}
