<?php

namespace Nicorette\CentralBundle\Services;

use Nicorette\CentralBundle\Entity\SequenceNumber;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * service pour l'export des données
 * @Service(id="export_service")
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class ExportService
{
    private $em;
    private $container;
//    public  $csvSeparator=';';
    public  $csvSeparator='¤¤';
    private $sequenceOfTheDay=1;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine')->getManager();
    }
    public function createCsvFile($FileCode,$SourceCode){
        $date = date("Ymd");
        $sequence=$this->getSequence($FileCode);//ToDo getSequence()
        $filename=$FileCode.'_'.$SourceCode.'_'.$date.'_'.$sequence.'.data';
        $fp = fopen($this->container->getParameter('rep_export') . "/" . $filename, 'a+');
        fclose($fp);
        return $filename;
    }
    public function getJanrainId($user){
        return $user->getJanrainId();
    }

    public function getSequence($fileCode){
        $sequenceNumber=$this->em->getRepository('NicoretteCentralBundle:SequenceNumber')->findOneByFileCode($fileCode);
        if(!$sequenceNumber){
            $sequenceNumber= new SequenceNumber();
            $sequenceNumber->setFileCode($fileCode);
            $sequenceNumber->setSequence(1);
            $this->em->Persist($sequenceNumber);
            $this->em->flush();
            $this->sequenceOfTheDay=1;
        }else{
            if($sequenceNumber->getUpdatedAt()->format('Ymd')==date('Ymd')){
                $this->sequenceOfTheDay=$sequenceNumber->getSequence()+1;
                $sequenceNumber->setSequence($this->sequenceOfTheDay);
                $this->em->persist($sequenceNumber);
                $this->em->flush();
            }elseif($sequenceNumber->getUpdatedAt()->format('Ymd')!=date('Ymd')){
                $sequenceNumber->setSequence(1);
                $this->sequenceOfTheDay=1;
                $this->em->persist($sequenceNumber);
                $this->em->flush();
            }
        }
        return str_pad($this->sequenceOfTheDay,3,0,STR_PAD_LEFT);
    }


    /* creates a compressed zip file */
    public function create_zip($files = array(),$destination = '',$overwrite = false) {
        //if the zip file already exists and overwrite is false, return false
        if(file_exists($destination) && !$overwrite) { return false; }
        //vars
        $valid_files = array();
        //if files were passed in...
        if(is_array($files)) {
            //cycle through each file
            foreach($files as $file) {
                //make sure the file exists
                if(file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if(count($valid_files)) {
            //create the archive
            $zip = new \ZipArchive();
            if($zip->open($destination,$overwrite ? \ZIPARCHIVE::OVERWRITE : \ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach($valid_files as $file) {
                $filename=explode('/',$file);
                $filename=array_pop($filename);
                $zip->addFile($file,$filename);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        }
        else
        {
            return false;
        }
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