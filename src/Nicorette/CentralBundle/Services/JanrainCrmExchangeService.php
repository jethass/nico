<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * echange de profil de l'utilisateur entre Janrain et CRM Service
 * @Service(id="janrain_crm_exchange_service")
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class JanrainCrmExchangeService
{
    private $em;
    private $container;
    private $payload;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }

    public function SyncJanrainUserProfile($uuid,$method)
    {
        $userProfile=$this->getProfileFromJanraian($uuid);
        if($userProfile->stat == 'ok'){
            $crmProfile=$this->mapProfileForCrm($userProfile);
            if($this->sendDataToCrm($crmProfile,$method,$this->container->getParameter('crm_url'))){
//                print_r('La synchronisation est éffectuer avec succès');
                return true;
            }else return false;

        }else {
//            print_r($userProfile->error_description.PHP_EOL);
            return false;
        }

    }
    public function getProfileFromJanraian($uuid){
        //création d'un contexte d'appel de type POST
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
            )
        );
        $context = stream_context_create($opts);
        $janrainParams=$this->container->getParameter('janrain_params');
        $fields_string_urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
        $postJanrain=$this->container->getParameter('janrain_uri').'?'.$fields_string_urlified.'&uuid='.$uuid;
        //Utilisation du contexte dans l'appel
        $userProfile = file_get_contents($postJanrain ,false,$context);
        return json_decode($userProfile);
    }
    public function mapProfileForCrm($janrainProfile){
        //don't add if email not verified
        $this->payload=array();
        $this->payload['JanrainId']=$janrainProfile->result->uuid;
        $this->payload['Source']='ACCOMPLIS';//ToDo ACCOMPLIS
        $this->payload['Civility']=$this->getCivility($janrainProfile->result->civility);
        $this->payload['Firstname']=$janrainProfile->result->givenName;
        $this->payload['Lastname']=$janrainProfile->result->familyName;
        $this->payload['Address1']=$janrainProfile->result->primaryAddress->address1;
        $this->payload['Address2']=$janrainProfile->result->primaryAddress->address2;
        $this->payload['Address3']=$janrainProfile->result->primaryAddress->address3;
        $this->payload['Address4']=$janrainProfile->result->primaryAddress->address4;
        $this->payload['PostalCode']=$janrainProfile->result->primaryAddress->zip;
        $this->payload['City']=$janrainProfile->result->primaryAddress->city;
        $this->payload['Country']=$janrainProfile->result->primaryAddress->country;
        $this->payload['Birthdate']=date("Ymd", strtotime($janrainProfile->result->birthday));
        $this->payload['Age'] = $this->calculateAge($this->payload['Birthdate']);
        $this->payload['Mobile']=$janrainProfile->result->primaryAddress->mobile;
        $this->payload['MobileDQMResult']='1';//on suppose que le num mobile est toujours traité
        $this->payload['Email']=$janrainProfile->result->email;
        $this->payload['EmailDQMResult']='V';//on suppose que l'email est toujours traité
        $this->payload['OptinBrand']=$janrainProfile->result->optins[0]->optinStatus;
        $this->payload['OptinJJSBF']=$janrainProfile->result->optins[1]->optinStatus;
        $this->payload['OptinOtherMember']=$janrainProfile->result->optins[2]->optinStatus;
//        $this->payload['OptinPharmacoVigilance']=$janrainProfile->result->optins[3]->optinStatus;;// ce parametre vas etre ajouter ulterieurement dans la page inscription
        $this->payload['OptinPharmacoVigilance']=0;//todo
        $this->payload['CustomerType']=$this->getCustomerType(isset($janrainProfile->result->customerType)?$janrainProfile->result->customerType:'B2C');//toujours "B2C" apret le conf call avec le client
        $this->payload['Job']=$janrainProfile->result->job;
        $this->payload['PreferedMedia']=$this->getPreferedMedia($janrainProfile->result->preferredMedia);


        //le reste n'est pas obligatoire, donc on l'ignore pour la création, car ça vas etre traiter par l'export==> proposition du chef du projet
//        $this->payload['KnowTheClubByADoctor']=$this->em->getRepository('NicoretteCentralBundle:Answer')->KnowTheClubByADoctor($uuid);
//
//        $this->payload['ObserviaDeclination']=$this->getObserviaDeclination($uuid);//Binary sequence of 8 characters 00000000 mean no declination
//
//        $this->payload['FagerstromDependencyLevel']=$janrainProfile->result->;
//        $this->payload['PsychoTypologyScore']=$janrainProfile->result->;//Score between 0 and 10
//        $this->payload['SocialTypologyScore']=$janrainProfile->result->;//Score between 0 and 10
//        $this->payload['ComportementalTypologyScore']=$janrainProfile->result->;//Score between 0 and 10
//        $this->payload['RecompenseTypologyScore']=$janrainProfile->result->;//Score between 0 and 10
//        $this->payload['SmokerStatus']=$janrainProfile->result->;
//        $this->payload['Contractingdate']=$janrainProfile->result->;//Datetime Format yyyymmdd hh24:mi:ss
//        $this->payload['SmokingStopDate']=$janrainProfile->result->;//Date Format yyyymmdd
        return $this->payload;
    }
     public function getCivility($civility){
         switch(strtolower($civility)){
             case 'mr': $payload['Civility']=1;//Mr
             case 'mme': $payload['Civility']=2;//MME
             case 'mle': $payload['Civility']=3;//MLE
             default :$payload['Civility']=1;//Mr
         }
         return $payload['Civility'];
     }

    public function calculateAge($birthdate){
        // calculer l'age et ne pas utiliser celui du schema de janrain
//        $this->payload['Age'] =$janrainProfile->result->age;
        $from  = new \DateTime($birthdate);
        $to   = new \DateTime('today');
        return $from->diff($to)->y;
    }

    public function getPreferedMedia($media){
        switch(strtolower ($media)){
        case "none":$payload['PreferedMedia']=1;//ça n'existe pas dans le crm prefered media  = 0
        case "mobile":$payload['PreferedMedia']=1;//integer
        case "email":$payload['PreferedMedia']=2;//integer
        case "postal":$payload['PreferedMedia']=3;//integer
        }
        return $payload['PreferedMedia'];
    }
    public function getCustomerType($type)
    {
//        switch($type){
//            case "B2C": return 1;
//            case "B2B": return 2;
//            case "B2B Healthcare": return 3;
//        }
        return 1;//toujours "B2C" apret le conf call avec le client}
    }

    public function sendDataToCrm($crmProfile,$method,$url){
        $fields_string = (is_array($crmProfile)) ? http_build_query($crmProfile) : $crmProfile;
        if($method == "POST"){
            $result=$this->doPost($url,$fields_string);
        }elseif($method == "PUT"){
            $url = $url.'/'.array_shift($crmProfile);
            $result= $this->doPut($url,$fields_string);
        }
        return $result;
    }

    public function doPut($url,$fields_string){
        if($ch = curl_init($url))
        {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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
            return true;
        }else return false;
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
            return true;
        }else return false;
    }

}