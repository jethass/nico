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
class CoachingSummary
{
    private $em;
    private $container;
    private $fileCode;
    private $sourceCode;
    private $exportService;
    private $batchSize = 50;
    private $persistedUser;

    public function __construct($container, $exportService)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
        $this->exportService = $exportService;
    }

    public function ExportCoachingSummary()
    {
        $this->fileCode = 'CoachingSummary';
        $this->sourceCode = 'accomplis';
        $filename = $this->exportService->createCsvFile($this->fileCode, $this->sourceCode);
        //find All Connected By Phone and Non Exported Users
        $users = $this->em->getRepository('NicoretteCentralBundle:Patient')->findAll();
        $methods = $this->container->getParameter('CoachingSummary');
        $handle = fopen($this->container->getParameter('rep_export') . "/" . $filename, 'a+');
        foreach ($users as $index => $user) {
            if ($this->exportService->userAnsweredAllQuiz($user)) {
                foreach ($methods as $key => $method) {
                    if (method_exists($this, $method))
                        $csvRow[$key] = $this->$method($user);
                    elseif (method_exists($this->exportService, $method)) {
                        $csvRow[$key] = $this->exportService->$method($user);
                    }
                }
                if (count($csvRow) > 0 && $handle) {
                    fputs($handle, implode($this->exportService->csvSeparator, $csvRow) . PHP_EOL);
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

    //les méthodes spécifiques
    public function getPointBalance($patient)
    {
        $points = $this->em->getRepository('NicoretteCentralBundle:PointHistory')->getPointsByPatient($patient);
        $sumPoint = 0;
        foreach ($points as $key => $point) {
            $sumPoint = $sumPoint + $point->getNbPoint();
        }
        return $sumPoint;
    }

    public function getLastFailedDate($patient)
    {
        $code = $this->container->getParameter('panic_button_cracked_code');
        return $this->getLastAswerOnQuiz($patient, $code);
    }

    public function getLastTemptationDate($patient)
    {
        $code = $this->container->getParameter('panic_button_not_cracked_code');
        return $this->getLastAswerOnQuiz($patient, $code);
    }

    public function getNbFailed($patient)
    {
        $code = $this->container->getParameter('panic_button_cracked_code');
        return $this->countAnswerOnQuiz($patient, $code);
    }


    public function getNbTemptation($patient)
    {
        $code = $this->container->getParameter('panic_button_not_cracked_code');
        return $this->countAnswerOnQuiz($patient, $code);
    }

    public function getNbOfCigarettesBeforeProgram($patient)
    {
        $diaryService = $this->container->get('nicorette.diary_service');
        return $diaryService->getConsumption($patient);
    }

    public function getPacketPrice($patient)
    {
        $economy = $patient->getPatientEconomys();
        if (count($economy) && is_object($economy[0])) {
            $amout = $economy[0]->getPrice() * 100;
            return $economy[0]->getPrice() != 0 ? str_pad($amout, 3, 0, STR_PAD_RIGHT) : 700;//le prix doit etre en euro cent
        } else return 700;
    }

    public function getRegisterDate($patient)
    {
        if ($patient && is_object($patient))
            return $patient->getCreatedAt()->format('Ymd');
        else
            return date('Ymd');
    }

    //les methodes génériques
    public function countAnswerOnQuiz($patient, $code)
    {
        $answersOnQuiz = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findAnswersQuizByPatientAndCode($patient, $code);
        return count($answersOnQuiz);
    }

    public function getLastAswerOnQuiz($patient, $code)
    {
        $lastAnswerOnQuiz = $this->em->getRepository('NicoretteCentralBundle:QuizAnswer')->findlastAnswerQuizByPatientAndCode($patient, $code);
        if ($lastAnswerOnQuiz != null && is_object($lastAnswerOnQuiz)) {
            return $lastAnswerOnQuiz->getCreatedAt()->format("Ymd H:i:s");
        } else return null;
    }
}