<?php
/**
 * Created by PhpStorm.
 * User: said.abdeljabar
 * Date: 05/02/2015
 * Time: 16:12
 */
namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * service pour l'export des données
 * @Service(id="export_service")
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class CoachingQuiz
{
    private $em;
    private $container;
    private $fileCode;
    private $sourceCode;
    private $exportService;

    public function __construct($container,$exportService)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
        $this->exportService = $exportService;
    }

    public function ExportCoachingQuiz(){
        $this->fileCode='CoachingQuiz';
        $this->sourceCode='accomplis';
        $filename=$this->exportService->createCsvFile($this->fileCode,$this->sourceCode);
        //find All Connected By Phone and Non Exported Users
        $users=$this->em->getRepository('NicoretteCentralBundle:Patient')->findAll();

        $methods=$this->container->getParameter('CoachingQuiz');
        $handle = fopen($this->container->getParameter('rep_export') . "/" . $filename, 'a+');
        foreach($users as $index=>$user) {
            if($this->exportService->userAnsweredAllQuiz($user)){
                foreach ($methods as $key => $method) {
                    if (method_exists($this, $method))
                        $csvRow[$key] = $this->$method($user);
                    elseif(method_exists($this->exportService, $method)){
                        $csvRow[$key] = $this->exportService->$method($user);
                    }
                }
                if (count($csvRow) > 0 && $handle) {
                    fputs($handle,implode($this->exportService->csvSeparator,$csvRow).PHP_EOL);
//                fputcsv($handle, $csvRow,$this->exportService->csvSeparator);
                }
            }
        }
        fclose($handle);
        //compresser le fichier compréssé
        $this->exportService->create_zip(array($this->container->getParameter('rep_export') . "/" . $filename),$this->container->getParameter('rep_export') . "/" . $filename.'.zip', true);
        //supprimer le fichier non compressé
        unlink($this->container->getParameter('rep_export') . "/" . $filename);
    }
//  les méthodes spécifiques
    public function getQuizDate($patient){
        $feedback1Code=$this->container->getParameter('feedback_1_quiz_code');
        $feedback2Code=$this->container->getParameter('feedback_2_quiz_code');
        $feedback3Code=$this->container->getParameter('feedback_3_quiz_code');
        $qaFeed1 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($patient, $feedback1Code);
        $qaFeed2 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($patient, $feedback2Code);
        $qaFeed3 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($patient, $feedback3Code);
        $date=array();
        $date[]=count($qaFeed1)>0 && $qaFeed1[0]&&$qaFeed1[0]->getCreatedAt()?$qaFeed1[0]->getCreatedAt()->format('Ymd'):'00000000';
        $date[]=count($qaFeed2)>0 && $qaFeed2[0]&&$qaFeed2[0]->getCreatedAt()?$qaFeed2[0]->getCreatedAt()->format('Ymd'):'00000000';
        $date[]=count($qaFeed3)>0 && $qaFeed3[0]&&$qaFeed3[0]->getCreatedAt()?$qaFeed3[0]->getCreatedAt()->format('Ymd'):'00000000';
        return count($date)>0 && max($date) !='00000000'?max($date):null;
    }
    public function getEstimatedStopDelay($patient){
        $question_id=$this->container->getParameter('estimated_stop_delay_question_id');
        $choices_ids=$this->container->getParameter('EstimatedStopDelay');
        $choiceAnswered=$this->getChoiceIdForAnswer($patient,$question_id);
        return in_array($choiceAnswered,$choices_ids)?array_search($choiceAnswered,$choices_ids):null;
    }
    public function getSmokingReason($patient){
        $choices_id_answered=array();
        $question_id=$this->container->getParameter('smoking_reason_question_id');
        $choices_ids=$this->container->getParameter('SmokingReason');
        $answers=$this->getAnswersForQuestion($patient,$question_id);
        foreach($answers as $key=>$answer)
            $choices_id_answered[$key]=$answer->getChoice()->getID();
        $intersection=array_intersect($choices_ids,$choices_id_answered);
        $result='';
        foreach($choices_ids as $key=>$choices_id){
            if(in_array($choices_id,$intersection)){
                $result.='1';
            }else $result.='0';
        }
        $answerOnQuiz=$this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswerQuizByPatientAndCode($patient, $this->container->getParameter('feedback_1_quiz_code'));//var_dump($answerOnQuiz);die;
        return $answerOnQuiz?$result:null;
    }
    public function getStopObstacle($patient){
        $question_id=$this->container->getParameter('stop_obstacle_question_id');
        $choices_ids=$this->container->getParameter('StopObstacle');
        $choiceAnswered=$this->getChoiceIdForAnswer($patient,$question_id);
        return in_array($choiceAnswered,$choices_ids)?array_search($choiceAnswered,$choices_ids):null;
    }
    public function getStopReason($patient){
        $choices_id_answered=array();
        $question_id=$this->container->getParameter('stop_reason_question_id');
        $choices_ids=$this->container->getParameter('StopReason');
        $answers=$this->getAnswersForQuestion($patient,$question_id);
        foreach($answers as $key=>$answer)
            $choices_id_answered[$key]=$answer->getChoice()->getID();
        $intersection=array_intersect($choices_ids,$choices_id_answered);
        $result='';
        foreach($choices_ids as $key=>$choices_id){
            if(in_array($choices_id,$intersection)){
                $result.='1';
            }else $result.='0';
        }
        return strpos($result, "1")!== false?$result:null;
    }
    public function getHasAlreadyTried($patient){
        $question_id=$this->container->getParameter('has_already_tried_question_id');
        $choices_ids=$this->container->getParameter('HasAlreadyTried');
        $choiceAnswered=$this->getChoiceIdForAnswer($patient,$question_id);
        return in_array($choiceAnswered,$choices_ids)?array_search($choiceAnswered,$choices_ids):null;
    }
    public function getFirstPeriodCigarette($patient){
        $question_id=$this->container->getParameter('first_period_cigarette_question_id');
        $choices_ids=$this->container->getParameter('FirstPeriodCigarette');
        $choiceAnswered=$this->getChoiceIdForAnswer($patient,$question_id);
        return in_array($choiceAnswered,$choices_ids)?array_search($choiceAnswered,$choices_ids):null;
    }
    public function getCigaretMostDiffcultAbort($patient){
        $question_id=$this->container->getParameter('cigarette_most_difficult_abort_question_id');
        $choices_ids=$this->container->getParameter('CigaretMostDiffcultAbort');
        $choiceAnswered=$this->getChoiceIdForAnswer($patient,$question_id);
        return in_array($choiceAnswered,$choices_ids)?array_search($choiceAnswered,$choices_ids):null;
    }
    public function getKnowHow($patient){
        $question_id=$this->container->getParameter('know_how_question_id');
        $choices_ids=$this->container->getParameter('KnowHow');
        $choiceAnswered=$this->getChoiceIdForAnswer($patient,$question_id);
        return in_array($choiceAnswered,$choices_ids)?array_search($choiceAnswered,$choices_ids):null;
    }

    //les methodes génériques
    public function getChoiceIdForAnswer($patient,$question_id){
        $answers=$this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($patient, $question_id);
        $choiceId= $answers && $answers[0]&& $answers[0]->getChoiceId() ?$answers[0]->getChoiceId():0;
        return $choiceId;
    }
    public function getAnswersForQuestion($patient,$question_id){
        $answers=$this->em->getRepository('NicoretteCentralBundle:Answer')->findAnswersByPatientAndQuestion($patient, $question_id);
        return $answers;
    }

    public function userAnsweredAllQuiz($patient){
        $feedback1Code=$this->container->getParameter('feedback_1_quiz_code');
        $feedback2Code=$this->container->getParameter('feedback_2_quiz_code');
        $feedback3Code=$this->container->getParameter('feedback_3_quiz_code');
        $qaFeed1 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($patient, $feedback1Code);
        $qaFeed2 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($patient, $feedback2Code);
        $qaFeed3 = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($patient, $feedback3Code);
        if($qaFeed1 && $qaFeed2 && $qaFeed3)
            return true;
        else return false;
    }
}