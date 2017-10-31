<?php

namespace Nicorette\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;
use Nicorette\CentralBundle\Entity\Patient;
use Nicorette\CentralBundle\Entity\PatientEconomy;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UsersController extends Controller
{

    /**
     * @Get("/user/auth", name="user_auth", options={ "method_prefix" = false })
     * @QueryParam(name="uuid", description="janrain user id.")
     * @ApiDoc(
     *  description="Authenticate User, add or update it in local bdd",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"},
     *      {"name"="expires", "dataType"="string", "required"=true, "description"="janrain user expiration date"}
     *  }
     * )
     * 
     */
	public function authUserAction(Request $request, ParamFetcher $paramFetcher)
	{
        $view = FOSView::create();
        $uuid = $request->get('uuid');
        $points = $this->container->getParameter('points');
        $em = $this->getDoctrine()->getManager();
		$patient = $em->getRepository('NicoretteCentralBundle:Patient')->findOneBy(array('janrainId'=>$uuid));
        if(!$patient){
            $patient = new Patient();
            $patientEconomy = new PatientEconomy();
            $patientEconomy->setPatient($patient);
            $patientEconomy->setPaquetSize($this->container->getParameter('packet_cigarette'));
            $patientEconomy->setPrice($this->container->getParameter('amount_cigarette'));
            $em->persist($patientEconomy);
        }
        $patient->setData($request, $uuid);

        $tools = $this->get('nicorette.tools');
        $session = $this->get('nicorette.session');

		if(!count($this->get('validator')->validate($patient))):
            $em->persist($patient);
            $em->flush();
            $economy = $em->getRepository('NicoretteCentralBundle:PatientEconomy')->findOneByPatient($patient);
            if($economy){
            	$economy->setPaquetSize($economy->getPaquetSize()?$economy->getPaquetSize():$this->container->getParameter('packet_cigarette'));
            	$economy->setPrice($economy->getPrice()?$economy->getPrice():$this->container->getParameter('amount_cigarette'));
            }else{
            	$economy = new PatientEconomy();
            	$economy->setPatient($patient);
            	$economy->setPaquetSize($this->container->getParameter('packet_cigarette'));
            	$economy->setPrice($this->container->getParameter('amount_cigarette'));
            }
            $em->persist($economy);
            $em->flush();
            $result['success'] = true;
            $result['data'] = $tools->getUserCurrentStep($patient);
        else:
            $result['success'] = false;
			foreach($this->get('validator')->validate($patient) as $error):
                $result['errors'][] = $error->getMessageTemplate();
            endforeach;
        endif;
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Get("/user/save/{uuid}", name="user_synchronize", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="add or update user in CRM",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"},
     *      {"name"="method", "dataType"="string", "required"=true, "description"="Methode POST pour la creation d'un utilisateur"}
     *  }
     * )
     * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
     *
     */
	public function saveUserAction(Request $request, $uuid)
	{
        $view = FOSView::create();
        $method = $request->get('method');
        $em = $this->getDoctrine()->getManager();
        $points = $this->container->getParameter('points');
        $janrainTool = $this->get('janrain_crm_exchange_service');
        $tools = $this->get('nicorette.tools');
        $session = $this->get('nicorette.session');
        
        $profile= $janrainTool->SyncJanrainUserProfile($uuid,$method);
        
        /*save new patient*/
        $patient = new Patient();
        $patient->setData($request, $uuid);
        $em->persist($patient);
        $em->flush();
        $economy = new PatientEconomy();
        $economy->setPatient($patient);
        $economy->setPaquetSize($this->container->getParameter('packet_cigarette'));
        $economy->setPrice($this->container->getParameter('amount_cigarette'));
        $em->persist($economy);
        $em->flush();
        $data = $session->saveAnswersFromTmp($uuid, $points, $patient);
        $contrat = $tools->getNotFixContrat($patient);
        if($profile){
            $result['success'] = true;
            $result['data']['contraturl'] = $contrat?$contrat:'contrat/1';
            $result['data']['msg'] = 'Utilisateur ajouter avec succès';
        }else{
            $result['success'] = false;
            $result['errors'][] = 'erreur survenue.';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Get("/user/verificationCode/{uuid}", name="user_get_verification_code", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="get VerificationCode from janrains",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="email", "dataType"="string", "required"=true, "description"="user email"},
     *      {"name"="status", "dataType"="string", "required"=true, "description"="user status"}
     *  }
     * )
     *
     */
	public function getverificationCodeAction(Request $request, $uuid)
	{
        $view = FOSView::create();
        $email = $request->get('email');
        $status = $request->get('status');
        $userTools = $this->get('user_tools_service');
        $userTools->updateStatus($uuid, $status);
        $code = $userTools->getVerificationCode($uuid);
        $session = $this->get('nicorette.session');
		if($code){
			$session->saveTmpFeedback($uuid);
			$confirmLink = $this->container->getParameter('base_url').$this->generateUrl('user_confirmation')."?verification_code=".$code;
            $data = $userTools->sendConfirmMail($email, $confirmLink);
            $result['success'] = true;
            $result['data']['message'] = $data;
        }else{
            $result['success'] = false;
            $result['errors'][] = 'erreur survenue.';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Get("/user/verificationEmailPhone", name="user_get_verification_email", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="get VerificationCode email and phone",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  
     * )
     *
     */
    public function getverificationEmailAndPhoneAction(Request $request)
    {
    	$view = FOSView::create();
    	$email = $request->get('email');
    	$phone = $request->get('phone');
    	
    	$result = array();
    	if( $email || $phone ){
    		$result['success'] = true;
    		$userTools = $this->get('user_tools_service');
    		if($email){
    			$result['email'] = array();
    			$data = $userTools->getVerificationEmail( $email );
    			$result['email']['message'] = $data;
    		}
    		if($phone){
    			$result['phone'] = array();
    			$data = $userTools->getVerificationPhone( $phone );
    			$result['phone']['message'] = $data;
    		}
    	}else{
    		$result['success'] = false;
    		$result['errors'] = 'erreur survenue.';
    	}
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
    
    /**
     * @Get("/cities/getCities/{zip}", name="cities_get_cities_name", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="get cities names by zip code",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="zip", "dataType"="string", "required"=true, "description"="zip code"},
     *  }
     * )
     *
     */
    public function getCitiesNamesAction(Request $request, $zip) {
        $view = FOSView::create();
        $userTools = $this->get('user_tools_service');
        $cities = $userTools->getCitiesNames($zip);
        $result['success'] = true;
        $result['data'] = $cities;
        $view->setStatusCode(200)->setData($result);
        return $view;
    }
    
    /**
     * @Get("/cities/getZipCodes/{city}", name="cities_get_zip_codes", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="get zip codes by city name",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="city", "dataType"="string", "required"=true, "description"="city name"},
     *  }
     * )
     *
     */
    public function getZipCodesAction(Request $request, $city) {
        $view = FOSView::create();
        $userTools = $this->get('user_tools_service');
        $cities = $userTools->getZipCodes($city);
        $result['success'] = true;
        $result['data'] = $cities;
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Get("/user/forgot/authCode", name="user_forgot_authCode", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="get forgot Auth code from janrains",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="email", "dataType"="string", "required"=true, "description"="user email"},
     *  }
     * )
     *
     */
	public function getForgotAuthCodeAction(Request $request)
	{
        $view = FOSView::create();
        $email = $request->get('email');
        $userTools = $this->get('user_tools_service');
        $uuid = $userTools->getUuidByEmail($email);
		if($uuid){
			$link = $this->container->getParameter('base_url').$this->generateUrl('reset_password');
            $authorizationCode = $userTools->getAuthCode($uuid, $link);
			if($authorizationCode){
				$renewalLink = $link.'?code='.$authorizationCode;
                $forgotMail = $userTools->sendForgotMail($email, $renewalLink);
				if($forgotMail){
                    $result['success'] = true;
                    $result['data']['uuid'] = $uuid;
				}else{
                    $result['success'] = false;
                    $result['errors'][] = 'Email non envoyé.';
                }
			}else{
                $result['success'] = false;
                $result['errors'][] = 'Code invalide.';
            }
		}else{
            $result['success'] = false;
            $result['errors'][] = 'Email non existant.';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Get("/user/profile", name="user_profile", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="get user profile from janrains",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="user janarain id"},
     *  }
     * )
     *
     */
	public function getUserProfileAction(Request $request)
	{
        $view = FOSView::create();
        $uuid = $request->get('uuid');
        $userTools = $this->get('user_tools_service');
        $profile = $userTools->getProfile($uuid);
		if($profile){
            $result['success'] = true;
            $result['data']['profile'] = $profile;
		}else{
            $result['success'] = false;
            $result['errors'][] = 'Profile non existant.';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Get("/user/updateprofile", name="user_update_profile", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="update profile user",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="user janarain id"},
     *      {"name"="method", "dataType"="string", "required"=true, "description"="methode PUT pour mettre a jour le profile"},
     *      {"name"="packet", "dataType"="integer", "required"=false, "description"="Nombre de cigarette dans un packet de cigarette"},
	 *		{"name"="amount", "dataType"="integer", "required"=false, "description"="Prix packet cigarette"},
     *      {"name"="brand", "dataType"="bool", "required"=false, "description"="user optin brand"},
     *      {"name"="JJSBF", "dataType"="bool", "required"=false, "description"="user optin JJSBF"},
     *      {"name"="otherMember", "dataType"="bool", "required"=false, "description"="user optin otherMember"}
     *      
     *  }
     * )
     *
     */
	public function updateUserProfileAction(Request $request)
	{
        $view = FOSView::create();
        $method = $request->get('method');
        $uuid = $request->get('uuid');
        $packet = $request->get('packet');
        $amount = $request->get('amount');
        $brand = $request->get('brand');
        $JJSBF = $request->get('JJSBF');
        $otherMember = $request->get('otherMember');

        $userTools = $this->get('user_tools_service');
        $janrainTool = $this->get('janrain_crm_exchange_service');

        $patientEconomy = $userTools->setEconomy($uuid, $packet, $amount);
        $optins = $userTools->updateOptins($uuid, $brand, $JJSBF, $otherMember);
        $profile= $janrainTool->SyncJanrainUserProfile($uuid,$method);

        if($profile){
        	$updatedProfile = $userTools->getProfile($uuid);
            $result['success'] = true;
            $result['data']['profile'] = $updatedProfile;
            $result['data']['msg'] = 'Utilisateur modifié avec succès';
        }else{
            $result['success'] = false;
            $result['errors'][] = 'erreur survenue.';
        }
        $view->setStatusCode(200)->setData($result);
        return $view;
    }
    
    
    /**
     * @Get("/user/fixlater", name="user_fix_later", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="fix contrat date later from janrains",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *  }
     * )
     *
     */
    public function fixLaterAction(Request $request)
    {
    	$view = FOSView::create();
    	$uuid = $request->get('uuid');
    	$em = $this->getDoctrine()->getManager();
    	$patient = $em->getRepository('NicoretteCentralBundle:Patient')->findOneBy(array('janrainId'=>$uuid));
    	
    	if($patient){
    		$patient->setFixLater(1);
    		$em->persist($patient);
    		$em->flush();
    		$result['success'] = true;
    	}else{
    		$result['success'] = false;
    		$result['errors'][] = 'erreur survenue.';
    	}
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }
    
    
    /**
     * @Get("/user/resendverificationCode", name="user_resend_verification_code", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="resend VerificationCode from janrains",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="email", "dataType"="string", "required"=true, "description"="janrain user email"},
     *  }
     * )
     *
     */
    public function resendverificationCodeAction(Request $request)
    {
    	$view = FOSView::create();
    	$email = $request->get('email');
    	$userTools = $this->get('user_tools_service');
    	$uuid = $userTools->getUuidByEmail($email);
    	$code = $uuid?$userTools->getVerificationCode($uuid):null;
    	
    	if($code){
    		$confirmLink = $this->container->getParameter('base_url').$this->generateUrl('user_confirmation')."?verification_code=".$code;
    		$data = $userTools->sendConfirmMail($email, $confirmLink);
    		$result['success'] = true;
    		$result['data']['message'] = $code;
    	}else{
    		$result['success'] = false;
    		$result['errors'][] = 'erreur survenue.';
    	}
    	$view->setStatusCode(200)->setData($result);
    	return $view;
    }

}
