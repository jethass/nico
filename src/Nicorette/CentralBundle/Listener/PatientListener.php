<?php

namespace Nicorette\CentralBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Nicorette\CentralBundle\Entity\PointHistory;

class PatientListener implements EventSubscriber {


    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function getSubscribedEvents() {
        return array(
            Events::postPersist
        );
    }

    public function postPersist(LifecycleEventArgs $args) {
    	$em = $args->getEntityManager();
    	$entity = $args->getEntity();
    	if($entity instanceof \Nicorette\CentralBundle\Entity\Patient){
    		/*add points*/
    		$this->container->get('nicorette.tools')->addPoint('patient_create', $entity);
    		
	    	$em->flush();
    	}
    }
    

}
