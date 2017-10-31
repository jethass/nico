<?php

namespace Nicorette\CentralBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckPointCommand extends ContainerAwareCommand {
	
	private $em;
	
    protected function configure() {
        $this ->setName('nicorette:check_point')
              ->setDescription('Mettre à jours les points des patients.Ce crone ne doit ètre exécuter q\'une fois par jour.');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	$this->em = $this->getDoctrine()->getManager();
        $check_point_service=$this->get('check_point_service');
       $check_point_service->updatePoint();
    }

    private function getDoctrine() {
        return $this->getContainer()->get('doctrine');
    }
    
    private function get($service) {
    	return $this->getContainer()->get($service);
    }
}