<?php

namespace Nicorette\CentralBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DataExportCommand extends ContainerAwareCommand {
	
	private $em;
	
    protected function configure() {
        $this ->setName('nicorette:data_export')
              ->setDescription('Export des donnée par rubrique')
              ->addArgument(
              		'Code',
              		InputArgument::OPTIONAL,
              		'code de l\'export de donnée "File Code_Source Code"'
              )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	$this->em = $this->getDoctrine()->getManager();
        $code = $input->getArgument('Code');
        $export_service=$this->get(strtolower($code).'.export_service');
        switch($code){
            case 'MobileConnectionHistory':{$export_service->ExportMobileConnectionHistory();break;}
//            case 'ClubConnectionHistory':{$export_service->ExportClubConnectionHistory();break;}
            case 'CoachingSummary':{$export_service->ExportCoachingSummary();break;}
            case 'CoachingQuiz':{$export_service->ExportCoachingQuiz();break;}
        }

    }

    private function getDoctrine() {
        return $this->getContainer()->get('doctrine');
    }
    
    private function get($service) {
    	return $this->getContainer()->get($service);
    }
}