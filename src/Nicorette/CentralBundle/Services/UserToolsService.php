<?php

namespace Nicorette\CentralBundle\Services;

use Nicorette\CentralBundle\Entity\Patient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Nicorette\CentralBundle\Entity\PatientEconomy;


/**
 * @Service(id="user_tools_service")
 * @author  Dalla Maher<maher.dalla@proxym-it.com>
 */

class UserToolsService
{
    private $em;
    private $container;
    private $payload;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }
    
    public function getVerificationEmail($email){
    	$urlMail = $this->container->getParameter('clean_mail_url');
    	$Country="FR";    	
    	/*$client = new \SoapClient($urlMail, array('cache_wsdl' => WSDL_CACHE_NONE));
    	$obj->login = "login";
    	$obj->password = "password";
   		$obj->guid = "guid";
   		$obj->email = $email;
    	$obj->country = $Country;
    	$obj->correctingLevel = 1;
    	
		$retval = $client -> getRNVP($obj);
		var_dump($retval->getRNVPResult);
		echo 'Authentication : ' . $retval->getRNVPResult->AuthenticationReturnCode . ' Email : ' . $retval->getRNVPResult->MailReturnCode
   		*/
    	return NULL;
    }
    public function getVerificationPhone($phone){
    	$urlPhone = $this->container->getParameter('clean_phone_url');
    	$Country="FR";    	 
    	/*$client = new \SoapClient($urlPhone, array('cache_wsdl' => WSDL_CACHE_NONE));
    	$obj->login = "login";
		$obj->password = "password";
		$obj->guid = "guid";
		$obj->numPhone = $phone;
		$obj->countryCodeISO = $Country;
		$obj->format = 1;
		$obj->specialRejection = true;
		$obj->invalidPurification = false;
		
		$retval = $client -> getRNVP($obj);
		var_dump($retval->getRNVPResult);
		echo 'Authentication : ' . $retval->getRNVPResult->AuthenticationReturnCode . ' Phone : ' . $retval->getRNVPResult->PhoneReturnCode
	    	
    	*/ 
    	 
    	return NULL;
    }
    public function getVerificationCode($uuid){
    	$janrainParams=$this->container->getParameter('janrain_params');
    	$janrainParams['uuid'] = $uuid;
    	$janrainParams['attribute_name'] = "emailVerified";
    	$urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
    	$url = $this->container->getParameter('verification_code_url').$urlified;
    	$result = $this->doGet($url);
    	//var_dump($result);die;
    	if($result && strtolower($result->stat) == 'ok' && $result->verification_code)
    		return $result->verification_code;
    	return false;
    	
    }
    
    public function sendConfirmMail($email, $confirmLink){
    	$params = array();
    	
    	$params['email'] = $email;
    	$params['source'] = "ACCOMPLIS";
    	$params['Link'] = $confirmLink;
    	
    	$urlified = (is_array($params)) ? http_build_query($params) : $params;
    	
    	$url = $this->container->getParameter('confirmation_url');
    	$result = $this->doPost($url, $urlified);
    	if(isset($result->errors) && count($result->errors) > 0)
    		return false;
    	
    	return $result;
    	 
    }
    
    public function getUuidByEmail($email){
    	
    	$janrainParams=$this->container->getParameter('janrain_params');
    	$janrainParams['attributes'] = '["uuid"]';
    	$janrainParams['filter'] = "email='".$email."'";
    	
    	$urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
    	$url = $this->container->getParameter('find_entity_code_url');
    	$result = (array) $this->doPost($url, $urlified);
    	
    	if(isset($result['result_count']) && $result['result_count'] > 0){
    		if(isset($result['results']) && isset($result['results'][0]) ){
    			$obj = $result['results'][0];
    			return $obj->uuid;
    		}
    	}
    	return false;
    	
    }
    
    public function getAuthCode($uuid, $link){
    	$janrainParams=$this->container->getParameter('janrain_params');
    	$janrainParams['uuid'] = $uuid;
    	$janrainParams['for_client_id'] = $this->container->getParameter('for_client_id');
    	$janrainParams['redirect_uri'] = $link;
    	
    	$urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
    	$url = $this->container->getParameter('authorization_code_url');
    	$result = (array) $this->doPost($url, $urlified);
    	if(isset($result['stat']) && strtolower($result['stat']) == 'ok' && isset($result['authorizationCode']))
    		return $result['authorizationCode'];
    	return false;
    	 
    }
    
    public function sendForgotMail($email, $renewalLink){
    	$params = array();
    	 
    	$params['email'] = $email;
    	$params['source'] = "ACCOMPLIS";
    	$params['Link'] = $renewalLink;
    	 
    	$urlified = (is_array($params)) ? http_build_query($params) : $params;
    	 
    	$url = $this->container->getParameter('forgot_url');
    	$result = (array) $this->doPost($url, $urlified);
    	
    	if(isset($result['errors']) && count($result['errors']))
    		return false;
    	 
    	return $result;
    
    }
    
    public function getProfile($uuid){
    	$picture = null;
    	$janrainParams=$this->container->getParameter('janrain_params');
    	$janrainParams['uuid'] = $uuid;

    	$urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
    	$url = $this->container->getParameter('find_entity_url');
    	$result = (array) $this->doPost($url, $urlified);
    	$profile = null;
    	$economies = $this->em->getRepository('NicoretteCentralBundle:PatientEconomy')->findEconomyByUuid($uuid);
    	if(isset($result['stat']) && strtolower($result['stat']) == 'ok' && isset($result['result'])){
    		$data = $result['result'];
    		$optins = $data->optins;
    		$profile['birthday'] = $data->birthday;
    		$profile['familyName'] = $data->familyName;
    		$profile['givenName'] = $data->givenName;
    		$profile['displayName'] = $data->displayName;
    		$profile['civility'] = $data->civility;
    		$profile['BrandOpt'] = isset($optins[0])?$optins[0]->optinStatus:false;
    		$profile['JJSBF'] = isset($optins[1])?$optins[1]->optinStatus:false;
    		$profile['OtherMember'] = isset($optins[2])?$optins[2]->optinStatus:false;
    		$profile['packet'] = $economies?$economies->getPaquetSize():0;
    		$profile['amount'] = $economies?$economies->getPrice():0;
    		if($data->photos){
	    		foreach($data->photos as $photo):
	    			if($photo->type=="normal")
	    				$picture = $photo->value;
	    		endforeach;
    		}
    		$profile['picture'] = $picture?$picture:'';
    	}
    	return $profile?$profile:false;
    
    }
    
    public function setEconomy($uuid, $packet, $amount){
    	
    	$patient = $this->em->getRepository('NicoretteCentralBundle:Patient')->findOneBy(array('janrainId'=>$uuid));
    	$economy = $this->em->getRepository('NicoretteCentralBundle:PatientEconomy')->findEconomyByUuid($uuid);
    	$economy = $economy?$economy:new PatientEconomy();
    	if($economy){
    		$economy->setPatient($patient);
    		$economy->setPaquetSize($packet?$packet:0);
    		$economy->setPrice($amount?$amount:0);
    		$this->em->persist($economy);
    		$this->em->flush();
    	}
    	return true;
    
    }
    
    public function updateOptins($uuid, $brand, $JJSBF, $otherMember){
    	$janrainParams=$this->container->getParameter('janrain_params');
    	$now = new \DateTime('now');
    	$now = $now->format('Y-m-d H:i:s');
    	$brandValue['optinID'] = "CON_EMEA_FR_Nicorette_BrandOpt";
    	$brandValue['optinStatus'] = $brand;
    	$brandValue['optinCreationDate'] = $now;
    	$value[] = $brandValue;
    	$JJSBFValue['optinID'] = "CON_EMEA_FR_Nicorette_JJSBF";
    	$JJSBFValue['optinStatus'] = $JJSBF;
    	$JJSBFValue['optinCreationDate'] = $now;
    	$value[] = $JJSBFValue;
    	$otherMemberValue['optinID'] = "CON_EMEA_FR_Nicorette_OtherMember";
    	$otherMemberValue['optinStatus'] = $otherMember;
    	$otherMemberValue['optinCreationDate'] = $now;
    	$value[] = $otherMemberValue;

    	$janrainParams['uuid'] = $uuid;
    	$janrainParams['attribute_name'] = '/optins';
    	$janrainParams['value'] = json_encode($value);
    	 
    	$urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
    	$url = $this->container->getParameter('update_entity_url');
    	$result = (array) $this->doPost($url, $urlified);
    	if(isset($result['stat']) && strtolower($result['stat']) == 'ok')
    		return true;
    	return false;
    
    }
    
    
    public function updateStatus($uuid, $status){
    	$janrainParams=$this->container->getParameter('janrain_params');
    	
    	$optin['brandID'] = "Nicorette";
    	$optin['questionID'] = "customQuestion_smokerStatus";
    	$optin['response'] = $status?$status:1;
    	 
    	$value[] = $optin;
    	$janrainParams['uuid'] = $uuid;
    	$janrainParams['attribute_name'] = '/customQuestions';
    	$janrainParams['value'] = json_encode($value);
    
    	$urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
    	$url = $this->container->getParameter('update_entity_url');
    	$result = (array) $this->doPost($url, $urlified);
    	if(isset($result['stat']) && strtolower($result['stat']) == 'ok')
    		return true;
    	return false;
    
    }
    
    
    public function doPost($url,$fields_string){
        if($ch = curl_init($url))
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($fields_string)));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            $result=curl_exec($ch);
            $err = curl_errno ( $ch );
            $errmsg = curl_error ( $ch );
            $header = curl_getinfo ( $ch );
            $httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
            curl_close($ch);
            return json_decode($result);
        }else return false;
    }
    
    public function doGet($url){
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => $url,
			    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);
			return json_decode($resp);
    }
    
    public function getCitiesNames($zip) {
        $cities = $this->em->getRepository('NicoretteCentralBundle:cities')->findCitiesByZipCode($zip);
        
        return $cities;
    }
    
    public function getZipCodes($city) {
        $zipCodes = $this->em->getRepository('NicoretteCentralBundle:cities')->findZipCodesByCity($city);
        
        return $zipCodes;
    }

    public function deleteUserFromJanrain($uuid){
        $janrainParams=$this->container->getParameter('janrain_params');
        $janrainParams['uuid'] = $uuid;
        $urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
        $url = $this->container->getParameter('delete_entity_url');
        return $this->doPost($url,$urlified);

    }

    public function deleteCoachingData($user){
//        delete contract
        foreach($user->getContracts() as $contract){
            $this->em->remove($contract);
        }
//        delete contacts
        foreach($user->getContacts()  as $contact){
            $this->em->remove($contact);
        }
//        delete judgment
        foreach($user->getJudgments()  as $judgment){
            $this->em->remove($judgment);
        }
//        delete patient economy
        foreach($user->getPatientEconomys()  as $patientEconomy){
            $this->em->remove($patientEconomy);
        }
//        delete point history
        foreach($user->getPointHistories()  as $point){
            $this->em->remove($point);
        }
//        delete quiz answers and answers with cascase delete
        foreach($user->getQuizAnswers() as $quizAnswer){
            try {
                $this->em->remove($quizAnswer);
            } catch (Exception $e) {var_dump($e->getMessage());
            }
        }
//        $this->em->persist($user);
        $this->em->flush();

    }
    public function handlyClone($user){
        $clone=new Patient();
        $clone->setClubAlerts($user->isClubAlerts());
        $clone->setCreatedAt($user->getCreatedAt());
        $clone->setExpiredAt($user->getExpiredAt());
        $clone->setJanrainId($user->getJanrainId());
        $clone->setJohnsonAlerts($user->isJohnsonAlerts());
        $clone->setStatus($user->getStatus());
        $clone->setToken($user->getToken());
        $clone->setUpdatedAt($user->getUpdatedAt());
        $clone->setFixLater($user->getFixLater());
        return $clone;
    }

}