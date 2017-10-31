<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Nicorette\CentralBundle\Entity\Answer;
use Nicorette\CentralBundle\Entity\QuizAnswer;

/**
 * service pour la gestion du plan d'action d'un patient
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class ActionPlanService
{

    private $em;
    private $container;
    /**
     * @var array
     */
    private static $scoreParams = array(
        'C' => 0,
        'P' => 0,
        'A' => 0,
        'M' => 0,
        'Beh' => 0,
        'Ppath' => 0,
        'Psoc' => 0,
        'Phys' => 0,
        'Rew' => 0,
        'C/R' => 0,
        'Fagerstrom' => 0,
        'MotHPres' => 0,
        'MotHFut' => 0,
        'MotSoc' => 0,
        'MotMon' => 0,
        'MotSelf' => 0,
        'OthSmok' => 0
    );

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }

    public function isKnownByDoctor($user)
    {
        $choiceIds = $this->container->getParameter('known_by_doctor_ids');
        $quiz = $this->em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($this->container->getParameter('feedback_3_quiz_code'));
        $knownByDoctor = $this->em->getRepository('NicoretteCentralBundle:Answer')->isKnownByDoctor($user, $quiz, $choiceIds, 1);
        return $knownByDoctor ? true : false;
    }

    public function adaptQuizQuestions($quiz, $user, $choiceId)
    {
        $result = array();
        $quizQuestions = $quiz->getQuestions();
        $result['answersForQuestion'] = array();//contient les ids des question qu'on vas chercher leur réponces ulterieurment pour les envoyer avec le retour de ws
        $contracts = $user->getContracts();
        $today = new \DateTime('today');
        $today = $today->format('Y-m-d');//var_dump($contracts[0]->getStopDate()->format('Y-m-d') >= date('Y-m-d', strtotime($today . ' + 14 day')));die('tt');
        $accountCreatedAt = $user->getCreatedAt()->format('Y-m-d');
//      l'idée c'est de supprimer les questions non necessaire, par ce que quand on récupère le quiz, l'architecture initiale vas exposer le quiz avec ces question et chaque question avec les choix qui
//        correspont, aussi la manipulation des cas exeptionnellle ce fait de cette methode aussi, exemple : selon la reponse du pation dans le quiz d'entre on vas afficher un ensemble de choix==>le meme traitement que les question on subit

        if (count($contracts) > 0) {
        if ($contracts[0]->getStopDate() !== null) {

            if (($contracts[0]->getStopDate()->format('Y-m-d') > date('Y-m-d', strtotime($accountCreatedAt . ' + 14 day')) && $contracts[0]->getStopDate()->format('Y-m-d') != $contracts[0]->getCreatedAt()->format('Y-m-d'))) {
                //jour superieur superieur a j -14,  donc on affiche j-14, j - 7, j-1 et j

                unset($quizQuestions[4]);
                unset($quizQuestions[5]);

                if ($this->isRoomMateSmoking($user)) {
                    //si l'utilisateur a indiqué qu'il y avait d'autres fumeurs dans son foyer (dans le quiz d'entrée),
                    //on remplace ces phrases par "assurez-vous que les fumeurs dans votre foyer, savent que vous avez besoin de leur aide"
                    unset($quizQuestions[2]->choices[0]);//Jetez toutes vos cigarettes
                    unset($quizQuestions[2]->choices[1]);//Eloignez les cendriers
                    unset($quizQuestions[2]->choices[2]);//Séparez-vous de vos briquets
                } else {
                    unset($quizQuestions[2]->choices[4]);//assurez-vous que les fumeurs dans votre foyer, savent que vous avez besoin de leur aide
                }
                $result['answersForQuestion'] = $this->container->getParameter('question_id_for_quit_date_sup_forteen_days');
            } elseif ($contracts[0]->getStopDate()->format('Y-m-d') > date('Y-m-d', strtotime($accountCreatedAt . ' + 7 day')) && $contracts[0]->getStopDate()->format('Y-m-d') != $contracts[0]->getCreatedAt()->format('Y-m-d')) {
                //jour superieur superieur a j-7 donc on affiche j - 7, j-1 et j
                unset($quizQuestions[0]);
                unset($quizQuestions[4]);
                unset($quizQuestions[5]);
                if ($this->isRoomMateSmoking($user)) {
                    //si l'utilisateur a indiqué qu'il y avait d'autres fumeurs dans son foyer (dans le quiz d'entrée),
                    //on remplace ces phrases par "assurez-vous que les fumeurs dans votre foyer, savent que vous avez besoin de leur aide"
                    unset($quizQuestions[2]->choices[0]);//Jetez toutes vos cigarettes
                    unset($quizQuestions[2]->choices[1]);//Eloignez les cendriers
                    unset($quizQuestions[2]->choices[2]);//Séparez-vous de vos briquets
                } else {
                    unset($quizQuestions[2]->choices[4]);//assurez-vous que les fumeurs dans votre foyer, savent que vous avez besoin de leur aide
                }
                $result['answersForQuestion'] = $this->container->getParameter('question_id_for_quit_date_sup_seven_days');
            } elseif ($contracts[0]->getStopDate()->format('Y-m-d') >= date('Y-m-d', strtotime($accountCreatedAt . ' + 1 day')) && $contracts[0]->getStopDate()->format('Y-m-d') != $contracts[0]->getCreatedAt()->format('Y-m-d')) {
                //jour superieur superieur a j-1 donc on affiche j-1 et j
                unset($quizQuestions[0]);
                unset($quizQuestions[1]);
                unset($quizQuestions[4]);
                unset($quizQuestions[5]);

                if ($this->isRoomMateSmoking($user)) {
                    //si l'utilisateur a indiqué qu'il y avait d'autres fumeurs dans son foyer (dans le quiz d'entrée),
                    //on remplace ces phrases par "assurez-vous que les fumeurs dans votre foyer, savent que vous avez besoin de leur aide"
                    unset($quizQuestions[2]->choices[0]);//Jetez toutes vos cigarettes
                    unset($quizQuestions[2]->choices[1]);//Eloignez les cendriers
                    unset($quizQuestions[2]->choices[2]);//Séparez-vous de vos briquets
                } else {
                    unset($quizQuestions[2]->choices[4]);//assurez-vous que les fumeurs dans votre foyer, savent que vous avez besoin de leur aide
                }
                $result['answersForQuestion'] = $this->container->getParameter('question_id_for_quit_date_sup_one_day');
            } elseif ((($contracts[0]->getStopDate()->format('Y-m-d') == $contracts[0]->getCreatedAt()->format('Y-m-d') && in_array($choiceId, $this->container->getParameter('quit_smoking_ids'))) || ($contracts[0]->getStopDate()->format('Y-m-d') == $contracts[0]->getCreatedAt()->format('Y-m-d')))) {
                //arrét immediat
                unset($quizQuestions[0]);
                unset($quizQuestions[1]);
                unset($quizQuestions[2]);
                unset($quizQuestions[3]);
                unset($quizQuestions[5]);

                //traiter le cas specifique du mon plan immediat
                $diaryTools = $this->container->get('nicorette.diary_service');
                $consumption = $diaryTools->getConsumption($user);
                $scoreFager = $this->getFagerScoreByUser($user, $quiz);
                $scoreCR = $this->getCRScoreByUser($user);
                if ($scoreFager > 6 || ($scoreCR > 5 && $consumption > 10) || $consumption > 15) {
                    //on n'elimine pas le choix "Prenez rendez-vous avec votre médecin pour parler de votre sevrage."
                } else {
                    unset($quizQuestions[4]->choices[2]);
                }

                $result['answersForQuestion'] = $this->container->getParameter('question_id_for_quit_date_immediate');
            }

        }elseif ($contracts[0]->getLastCigarette() !== null && $contracts[0]->getLastCigarette()->format('Y-m-d') <= date('Y-m-d', strtotime($today . ' + 0 day')) && $contracts[0]->getLastCigarette()->format('Y-m-d') <= $contracts[0]->getCreatedAt()->format('Y-m-d') && in_array($choiceId, $this->container->getParameter('quit_smoking_ids'))) {//il faut que la date de la derniere cigarette fumer et inferieur a la date du jour, sinn on vas tombé dans le cas de immédiat
                // le patient à déja arréter de fumer==> passé
                unset($quizQuestions[0]);
                unset($quizQuestions[1]);
                unset($quizQuestions[2]);
                unset($quizQuestions[3]);
                unset($quizQuestions[4]);

                //traiter le cas specifique du mon plan passé
                $diaryTools = $this->container->get('nicorette.diary_service');
                $consumption = $diaryTools->getConsumption($user);
                $scoreFager = $this->getFagerScoreByUser($user, $quiz);
                $scoreCR = $this->getCRScoreByUser($user);
                if ($scoreFager > 6 || ($scoreCR > 5 && $consumption > 10) || $consumption > 15) {
                    //on n'elimine pas le choix "Prenez rendez-vous avec votre médecin pour parler de votre sevrage."
                } else {
                    unset($quizQuestions[4]->choices[2]);
                }

                $result['answersForQuestion'] = $this->container->getParameter('question_id_for_quit_date_passed');
            }
        } else {
            // il y a une erreur dans la base, non correspondance dans la basedonc on affiche rien pour le moment ToDo on affiche quoi par defaut
            unset($quizQuestions[0]);
            unset($quizQuestions[1]);
            unset($quizQuestions[2]);
            unset($quizQuestions[3]);
            unset($quizQuestions[4]);
            unset($quizQuestions[5]);
            $result['answersForQuestion'] = array();
        }
        $quiz->setQuestions($quizQuestions);
        $result['quiz'] = $quiz;
        return $result;
    }

    public function getFagerScoreByUser($patient, $quiz)
    {
        $answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($patient, $quiz);
        $score = $this->calculateScore($answers);
        return $score['Fagerstrom'];
    }

    public function getRecognizedProduct($patient, $scoreFager)
    {
        $question_id = $this->container->getParameter('seventh_question_feedback_2');//Qu’est-ce qui vous semble le plus important concernant votre sevrage tabagique ?
        $answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($patient, $question_id);
        if (count($answers) && $answers[0]->getChoiceId()) {
            if ($scoreFager && $scoreFager > 5) {
                $products = $this->container->getParameter('product_for_answer_fager_gt_5');
                return $answers[0]->getChoiceId() && $products[$answers[0]->getChoiceId()] ? $products[$answers[0]->getChoiceId()] : null;
            } else {
                $products = $this->container->getParameter('product_for_answer_fager_lt_5');
                return $answers[0]->getChoiceId() && $products[$answers[0]->getChoiceId()] ? $products[$answers[0]->getChoiceId()] : null;
            }
        }
    }

    public function calculateScore($answers)
    {
        foreach ($answers as $answer) {
            $Choice = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($answer->getChoiceId());
            $scoring = $Choice ? $Choice->getScoring() : null;
            foreach ($scoring as $key => $score) {
                self::$scoreParams[$key] += $score;
            }
        }
        return self::$scoreParams;
    }

    public function getLastAnswers($quiz, $user, $questions)
    {//get last answers for questions
        return true;
    }

    public function isRoomMateSmoking($patient)
    {
        $question_id = $this->container->getParameter('other_room_mate_smoke_question_id');
        $answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($patient, $question_id);
        $yesChoice = $answers && $answers[0] ? $answers[0]->getChoiceId() : null;
        if ($yesChoice == $this->container->getParameter('room_mate_smoke_yes_choice'))
            return true;
        return false;
    }

    public function getCRScoreByUser($user)
    {
        $quizCode = $this->container->getParameter('feedback_1_quiz_code');
        $quiz = $this->em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($quizCode);
        $answers = $this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuiz($user, $quiz);
        $score = $this->calculateScore($answers);
        return $score['C/R'];
    }
}

?>