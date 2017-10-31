<?php

namespace Nicorette\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nicorette\CentralBundle\Form\FileType;

class DefaultController extends Controller
{
    /**
     * @Route("/import", name="import")
     * @Template()
     */
    public function indexAction()
    {
   		$request = $this->get('request');
    	$form = $this->createForm(new FileType());
    	
    	if ($request->getMethod('post') == 'POST') {
    		$form->bind($request);
    		if ($form->isValid()) {
    			$file = $form->get('file')->getData();
    		    $fileImportData = $this->get('nicorette.csv.import')->QuizImport($file);
    		}
    	}
    	return array('form' => $form->createView());
    }
}
