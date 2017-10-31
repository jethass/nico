<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Nicorette\CentralBundle\Entity\Answer;
use Nicorette\CentralBundle\Entity\QuizAnswer;

/**
 * service pour la gestion des points à ajouter d'une façon auto à traver un crone
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class CheckPointService
{
    private $em;
    private $container;
    private $nicoTools;

    public function __construct($container, $nicoTools)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
        $this->nicoTools = $nicoTools;
    }

    public function updatePoint()
    {
        $today = new \DateTime();
        $checkPoint = $this->container->getParameter('check_point_params');
        // try to get all the users with the stop date who got a contract and their quit date is grater than today
        $contracts = $this->em->getRepository('NicoretteCentralBundle:Contract')->getContractedUsers();
        foreach ($contracts as $key => $contract) {
            $user = $contract->getPatient();
            if ($contract->getStopDate()) {
                $stopDate = $contract->getStopDate();
                $dateDiff = $today->diff($stopDate)->format('%a');
                if (array_key_exists($dateDiff, $checkPoint)) {
                    // ajouter les points relier au bonus des dates à atteindre durant la periode de programme
                    $this->nicoTools->addUserPoint($user, $dateDiff . '_day_without_smoking', $checkPoint[$dateDiff], $this->em);
                }
                //l'existance d'une reponse de patient sur j'ai craqué ou j'ai fumé pour aujoud'hui
                $code = $this->container->getParameter('panic_button_cracked_code');
                $answerOnCracked = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findlastAnswerQuizByPatientAndCode($user, $code);
                $code = $this->container->getParameter('panic_button_cracked_code');
                $answerOnMyDiary = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findlastAnswerQuizByPatientAndCode($user, $code);
                //ajouter les points relier au bonus journalier des points si le patient n'a pas craqué
                if (($answerOnCracked && $answerOnCracked->getCreatedAt()->format('Y-m-d') == $today->format('Y-m-d')) || ($answerOnMyDiary && $answerOnMyDiary->getCreatedAt()->format('Y-m-d') == $today->format('Y-m-d') ) ) {//do nothing
                } else {
                    $this->nicoTools->addUserPoint($user, $this->container->getParameter('point_per_day_after_quit_date') . '_point_per_day', $this->container->getParameter('point_per_day_after_quit_date'), $this->em);
                }
                //ajouter les point relier a la consommation initiale des cigarettes
                $diaryTools = $this->container->get('nicorette.diary_service');
                $consumption = $diaryTools->getConsumption($user);
                $this->nicoTools->addUserPoint($user, 'cigarette_point_per_day', $consumption, $this->em);
            } elseif ($contract->getLastCigarette()) {
                //then it's a client who stopped smoking earlier
                $stopDate = $contract->getCreatedAt();
                $dateDiff = $today->diff($stopDate)->format('%a');
                if (array_key_exists($dateDiff, $checkPoint)) {
                    // ajouter les points relier au bonus des dates à atteindre durant la periode de programme
                    $this->nicoTools->addUserPoint($user, $dateDiff . '_day_without_smoking', $checkPoint[$dateDiff], $this->em);
                }
                //l'existance d'une reponse de patient sur j'ai craqué ou j'ai fumé pour aujoud'hui
                $code = $this->container->getParameter('panic_button_cracked_code');
                $answerOnCracked = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findlastAnswerQuizByPatientAndCode($user, $code);
                $code = $this->container->getParameter('panic_button_cracked_code');
                $answerOnMyDiary = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findlastAnswerQuizByPatientAndCode($user, $code);
                //ajouter les points relier au bonus journalier des points si le patient n'a pas craqué
                if (($answerOnCracked && $answerOnCracked->getCreatedAt()->format('Y-m-d') == $today->format('Y-m-d')) || ($answerOnMyDiary && $answerOnMyDiary->getCreatedAt()->format('Y-m-d') == $today->format('Y-m-d'))) {//do nothing
                } else {
                    $this->nicoTools->addUserPoint($user, $this->container->getParameter('point_per_day_after_quit_date') . '_point_per_day', $this->container->getParameter('point_per_day_after_quit_date'), $this->em);
                }
                //ajouter les point relier a la consommation initiale des cigarettes
                $diaryTools = $this->container->get('nicorette.diary_service');
                $consumption = $diaryTools->getConsumption($user);
                $this->nicoTools->addUserPoint($user, 'cigarette_point_per_day', $consumption, $this->em);

            }
        }
    }

}

?>