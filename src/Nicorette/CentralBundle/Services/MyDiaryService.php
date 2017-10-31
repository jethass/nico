<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Nicorette\CentralBundle\Entity\Answer;
use Nicorette\CentralBundle\Entity\QuizAnswer;

/**
 * service pour la gestion de journal avant et aprèt la fixation de la date d'arrét
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */

class MyDiaryService
{

    private $em;
    private $container;
    private $answerEntity;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }
    public function getLastDifficutiLevelAfter($user,$quiz,$questionId){
        $levelsIds=$this->em->getRepository('NicoretteCentralBundle:Choice')->findChoicesIdsForQuestion($questionId);
        //retourner la derniere reponse sur ce quiz
        $lastAnswerOnLevel=$this->em->getRepository('NicoretteCentralBundle:Answer')->GetLastAnswersForQuiz($user,$quiz,$levelsIds,1);
        if($lastAnswerOnLevel){
            $lastAnswer=$this->em->getRepository('NicoretteCentralBundle:Choice')->findOneById($lastAnswerOnLevel->getChoice()->getId());
            return $lastAnswer->getName();
        } else
            return 0;
    }
    public function getAverageDifficutyAfter($user,$quiz,$return,$questionId){
        $average=0;
        $levelsIds=$this->em->getRepository('NicoretteCentralBundle:Choice')->findChoicesIdsForQuestion($questionId);
        //retourner la derniere reponse sur ce quiz
        $lastAnswersOnLevel=$this->em->getRepository('NicoretteCentralBundle:Answer')->GetLastAnswersForQuiz($user,$quiz,$levelsIds,7);
        if($lastAnswersOnLevel){

            foreach($lastAnswersOnLevel as $key=>$choice){
                $lastAnswer=$this->em->getRepository('NicoretteCentralBundle:Choice')->findOneById($choice->getChoice()->getId());
                if($lastAnswer->getId()==86){
                    //si la réponse est "J'ai fumé" donc le cota de cette réponse est egale à 11
                    $cota=11;
                }else
                    $cota=(integer)$lastAnswer->getName();
                $average=$average+$cota;
            }
            if($average > 0 )
                $average=($average/count($lastAnswersOnLevel));
        }
        switch($return){
            case 'average':{
                return $average;break;
            }
            case'countAnswers':{
                return count($lastAnswersOnLevel);
                                   break;
            }
                default :{
                return $average;break;
                }
        }

    }
//    public function isInsertedTodayAfter($user,$quiz){
//        $questionId=$this->container->getParameter('first_question_my_diary_after_id');
//        $levelsIds=$this->em->getRepository('NicoretteCentralBundle:Choice')->findChoicesIdsForQuestion($questionId);
//        //retourner la derniere reponse sur ce quiz
//        $lastAnswerOnLevel=$this->em->getRepository('NicoretteCentralBundle:Answer')->GetLastAnswersForQuiz($user,$quiz,$levelsIds,1);
//        if($lastAnswerOnLevel){
//            $today = date("Ymd");
//            $insertionDate=$lastAnswerOnLevel->getCreatedAt();
//            if($insertionDate->format('Ymd') == $today){
//                return true;
//            }
//            else
//                return false;
//        } else
//            return false;
//    }
    public function isInsertedTodayAfter($user,$quiz,$return,$questionId){
        $choicesIds=$this->em->getRepository('NicoretteCentralBundle:Choice')->findChoicesIdsForQuestion($questionId);
        //retourner la derniere reponse sur ce quiz
        $lastAnswerOnQuestion=$this->em->getRepository('NicoretteCentralBundle:Answer')->GetLastAnswersForQuiz($user,$quiz,$choicesIds,1);
        if($lastAnswerOnQuestion){
            $today = date("Ymd");
            $insertionDate=$lastAnswerOnQuestion->getCreatedAt();
            if($insertionDate->format('Ymd') == $today){
                $lastAnswer=$this->em->getRepository('NicoretteCentralBundle:Choice')->findOneById($lastAnswerOnQuestion->getChoice()->getId());
                return $this->getDesiredFormat($lastAnswer,$return,$lastAnswerOnQuestion);
            }
            else
                return false;
        } else
            return false;
    }

    public function isInsertedTodayBefore($user,$quiz,$return,$questionId){
        $choicesIds=$this->em->getRepository('NicoretteCentralBundle:Choice')->findChoicesIdsForQuestion($questionId);
        //retourner la derniere reponse sur ce quiz
        $lastAnswerOnChoice=$this->em->getRepository('NicoretteCentralBundle:Answer')->GetLastAnswersForQuiz($user,$quiz,$choicesIds,$limit=1);//if limit == 1 than it return an object
        if($lastAnswerOnChoice){
            $today = date("Ymd");
            $insertionDate=$lastAnswerOnChoice->getCreatedAt();
            if($insertionDate->format('Ymd') == $today){
                $lastAnswer=$this->em->getRepository('NicoretteCentralBundle:Choice')->findOneById($lastAnswerOnChoice->getChoice()->getId());
                return $this->getDesiredFormat($lastAnswer,$return,$lastAnswerOnChoice);
            }
            else
                return false;
        } else
            return false;
    }
    public function getDesiredFormat($lastAnswer,$return,$lastAnswerOnChoice){
        switch ($return) {
            case 'value': {
                if ($lastAnswer)
                    return $lastAnswer->getName();
                else return false;
                break;
            }
            case 'idAnswer': {
                if ($lastAnswerOnChoice)
                    return $lastAnswerOnChoice->getId();
                else return false;
                break;
            }

            case 'answerCreatedAt': {
                if ($lastAnswerOnChoice)
                    return $lastAnswerOnChoice->getCreatedAt();
                else return false;
                break;
            }
            case 'idChoice': {
                if ($lastAnswer)
                    return $lastAnswer->getId();
                else return false;
                break;
            }
            case 'boolean': {
                return true;
                break;
            }
            default : {
            if ($lastAnswer)
                return $lastAnswer->getName();
            else return false;
            }
        }
    }

    public function addUserAnswers($answers, $user, $quiz)
    {
        $quizAnswer = new QuizAnswer();
        $quizAnswer->setData($quiz, $user);
        $this->em->persist($quizAnswer);
        $this->em->flush();
        if ($answers) {
            foreach ($answers as $choice):
                    if (isset($choice['idChoice'])) {
                        $choiceEntity = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($choice['idChoice']);
                        if ($choiceEntity) {
                            $answer = new Answer();
                            $answer->setQuizAnswer($quizAnswer);
                            $answer->setChoice($choiceEntity);
                            $nbCigaret=$this->getDayObjectiveBefore($user, $quiz);//retourne le nombre de cigarette comme objectif du jour
                            $answer->setDayTarget($nbCigaret);
                            if (isset($choice['inputValue'])){
                                $answer->setAnswerText($choice['inputValue']);
                            }
                            if (isset($choice['order'])) {
                                $answer->setAnswerOrder($choice['order']);
                            }
                            $this->em->persist($answer);
                        }
                    }
            endforeach;
        }
        try {
            $this->em->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function mergeUserAnswers($answers)
    {
        if ($answers) {

            foreach ($answers as $key => $choice):
                    if (isset($choice['idAnswer'])) {
                        if($choice['idAnswer'] != false)
                            $this->answerEntity = $this->em->getRepository('NicoretteCentralBundle:Answer')->find($choice['idAnswer']);
                        else{
                            $quizAnswer=$this->answerEntity->getQuizAnswer();
                            $this->answerEntity = new Answer();
                            $this->answerEntity->setQuizAnswer($quizAnswer);
                        }
                        $choiceEntity = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($choice['idChoice']);
                        if ($choiceEntity && $this->answerEntity) {
                            $this->answerEntity->setChoice($choiceEntity);
                            if (isset($choice['inputValue'])){
                                $this->answerEntity->setAnswerText($choice['inputValue']);
                            }
                            if (isset($choice['order'])) {
                                $this->answerEntity->setAnswerOrder($choice['order']);
                            }
                            $this->em->persist($this->answerEntity);
                        }
                    }
            endforeach;
        }
        try {
            $this->em->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    public function getDayObjectiveBefore($user,$quiz){
        $reduction=$this->container->getParameter('reduction_percentage');
        //get the number of cigarette to achieve the goal of the current day
        $contract=$this->em->getRepository('NicoretteCentralBundle:Contract')->getLastContractsByUser($user);
        $stopDate=$contract && $contract->getStopDate()?$contract->getStopDate()->format('Y-m-d'):null;
        $contractCreatedAt=$contract && $contract->getCreatedAt()?$contract->getCreatedAt()->format('Y-m-d'):null;
        $inscriptionDate=$user->getCreatedAt()->format('Y-m-d');
        $now=date("Y-m-d");
//        $final = date("Y-m-d", strtotime("+3 month", $now));
        $consumption= $this->getConsumption($user);

        //traiter le cas si on a une periode de contemplation
        if($contractCreatedAt == null || $contractCreatedAt > $inscriptionDate){
            //si oui donc on a une peridoe de contemplation
            $consumption=$consumption*$reduction;
        }

        if($stopDate && $stopDate > $now ){
            $dayDuration = (strtotime($now) - strtotime($contractCreatedAt))/86400;
            $weekDuration=floor($dayDuration/7)>0?floor($dayDuration/7):1;
            for($key=0;$key < $weekDuration;$key ++){
//                $consumption=$consumption-($consumption*$reduction);
                $consumption=$consumption*$reduction;
            }
            $consumption= $consumption && $consumption > 1 ?ceil($consumption):1;
        }elseif($stopDate && $stopDate <= $now){
            $consumption=0;
        }
        return ceil($consumption);

    }

    //retourne le nombre de cigarette consommé par le patient renseigner dans le quiz d'entrée
     public function getConsumption($user){
         $choiceId=$this->container->getParameter('text_field_nb_cigarette_id');
         $quizCode=$this->container->getParameter('feedback_3_quiz_code');
         $quiz=$this->em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($quizCode);
         $consumption=$this->em->getRepository('NicoretteCentralBundle:Answer')->getConsumedCigarette($user,$quiz,$choiceId,1);
         return $consumption?$consumption->getAnswerText():1;
     }

    public function isKnownByDoctor($user){
        $choiceIds=$this->container->getParameter('known_by_doctor_ids');
        $quiz=$this->em->getRepository('NicoretteCentralBundle:Quiz')->findOneByCode($this->container->getParameter('feedback_3_quiz_code'));
        $knownByDoctor=$this->em->getRepository('NicoretteCentralBundle:Answer')->isKnownByDoctor($user,$quiz,$choiceIds,1);
        return $knownByDoctor?true:false;
    }
}

?>