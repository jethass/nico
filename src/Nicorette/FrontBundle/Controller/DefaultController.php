<?php

namespace Nicorette\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home"))
     * @Template()
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $mobileDetect = $this->get('nicorette.detect.mobile');
        $device = 'desktop';
        
        if($mobileDetect->isMobile() && !$mobileDetect->isTablet()){
        	if($mobileDetect->is('iOS')){
        		$device = 'iOS';
        	}elseif($mobileDetect->is('AndroidOS')){
        		$device = 'AndroidOS';
        	}elseif($mobileDetect->is('WindowsMobileOS') || $mobileDetect->is('WindowsPhoneOS')){
        		$device = 'WindowsMobileOS';
        	}else{
        		$device = 'mobile';
        	}
        }
        
        return $this->container->get('templating')->renderResponse('NicoretteFrontBundle:Default:desktop.html.twig', array('device'=> $device));
    }
    
    /**
     * @Route("/user-confirmation",  name="user_confirmation")
     * @Template()
     */
    public function userConfirmationAction()
    {
    	$mobileDetect = $this->get('nicorette.detect.mobile');
    	$device = 'desktop';
    	
    	if($mobileDetect->isMobile() && !$mobileDetect->isTablet()){
    		if($mobileDetect->is('iOS')){
    			$device = 'iOS';
    		}elseif($mobileDetect->is('AndroidOS')){
    			$device = 'AndroidOS';
    		}elseif($mobileDetect->is('WindowsMobileOS') || $mobileDetect->is('WindowsPhoneOS')){
    			$device = 'WindowsMobileOS';
    		}else{
    			$device = 'mobile';
    		}
    	}
    	return array('device'=> $device);
    }
    
    /**
     * @Route("/reset-password", name="reset_password")
     * @Template()
     */
    public function resetPasswordAction()
    {
    	$request = $this->getRequest();
    	$code = $request->get('code');
    	if(!$code)
    		return $this->redirect($this->generateUrl('home'));
    	$mobileDetect = $this->get('nicorette.detect.mobile');
    	$device = 'desktop';
    	
    	if($mobileDetect->isMobile() && !$mobileDetect->isTablet()){
    		if($mobileDetect->is('iOS')){
    			$device = 'iOS';
    		}elseif($mobileDetect->is('AndroidOS')){
    			$device = 'AndroidOS';
    		}elseif($mobileDetect->is('WindowsMobileOS') || $mobileDetect->is('WindowsPhoneOS')){
    			$device = 'WindowsMobileOS';
    		}else{
    			$device = 'mobile';
    		}
    	}
    	return array('device'=> $device);
    }
    
}
