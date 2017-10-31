<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Nicorette\CentralBundle\Entity\Question;
use Nicorette\CentralBundle\Entity\Quiz;
use Nicorette\CentralBundle\Entity\Choice;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
/**
 * Import Service 
 * @Service(id="import_csv_service")
 * @author  Maher Dalla <maher.dalla@proxym-it.com>
 */

class ImportCsvService {
	
	private $em;
	private $container;
	
	public function __construct($container) {
		$this->em = $container->get('doctrine')->getManager();
		$this->container = $container;
	}
    
    /**
     * importer de donnée depuis fichier csv 
     */
    
    public function QuizImport($file)
    {    	
    	if($this->isFile($file)){   
    		$row = 1; 
	    	// open the file with read permission 
	    	if (($handle = fopen($file, "r")) !== FALSE) 
	    	{ 
	    		$csvRow = fgetcsv($handle, 0, ";");
	    		while (($csvRow = fgetcsv($handle, 0, ";")) !== FALSE) 
	    		{ 
					$question = $this->em->getRepository('NicoretteCentralBundle:Question')->find((isset($csvRow[1]) && $csvRow[1]!='')?$csvRow[1]:null);
					$scoring = (isset($csvRow[4]) && $csvRow[4]!='')?explode(",",$csvRow[4]):null;
					$choice = new Choice();
	    			$choice->setName((isset($csvRow[0]) && $csvRow[0]!='')?$csvRow[0]:null);
	    			$choice->setQuestion($question);
	    			$choice->setNextQuestion((isset($csvRow[2]) && $csvRow[2]!='')?$csvRow[2]:null);
	    			$choice->setRenamedQuestion((isset($csvRow[3]) && $csvRow[3]!='')?$csvRow[3]:null);
	    			$choice->setScoring((isset($csvRow[4]) && $csvRow[4]!='')?$this->getScoring($scoring):null);
	    			$this->em->persist($choice);
	    			$row++;
	    		}
	    		try{
		            $this->em->flush();
	    			fclose($handle); //close file handler	 
	    		} catch (\Doctrine\DBAL\DBALException $e) {
		        }
	    	}else{
    		$errors[] = 'file.validate.format';
    		}
    	}
    	die;
    }
    
    /**
     * test l'existance d'un fichier csv
     */
    private function isFile($file)
    {
    	if (file_exists($file)) {
    		return true;
    	}else{
    		return false;
    	}
    }
    
    private function getScoring($array){
    	$scoring = array();
    	if($array){
    		foreach($array as $key => $score){
    			$score = explode(":",$score);
    			$scoring[$score[0]] = $score[1];
    		}
    	}
    	return $scoring;
    }
    
}
