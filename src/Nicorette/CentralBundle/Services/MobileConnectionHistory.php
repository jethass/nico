<?php
/**
 * Created by PhpStorm.
 * User: said.abdeljabar
 * Date: 05/02/2015
 * Time: 16:12
 */
namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * service pour l'export des données
 * @Service(id="export_service")
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class MobileConnectionHistory
{
    private $em;
    private $container;
    private $fileCode;
    private $sourceCode;
    private $exportService;
    private $batchSize = 50;
    private $persistedUser;

    public function __construct($container,$exportService)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
        $this->exportService = $exportService;
    }

    public function ExportMobileConnectionHistory(){
        $this->fileCode='MobileConnectionHistory';
        $this->sourceCode='accomplis';
        $filename=$this->exportService->createCsvFile($this->fileCode,$this->sourceCode);
        $this->persistedUser=0;
        //find All Connected By Phone and Non Exported Users
//        $users=$this->em->getRepository('NicoretteCentralBundle:Patient')->findAllCMNEUsers();
        $users=$this->getUsersFromJanrain();
        $count=$users->result_count;
        if($count > 0){
        $methods=$this->container->getParameter('MobileConnectionHistory');
        $handle = fopen($this->container->getParameter('rep_export') . "/" . $filename, 'a+');
        foreach($users->results as $index=>$user) {
            foreach ($methods as $key => $method) {
                if (method_exists($this, $method))
                    $csvRow[$key] = $this->$method($user);
                elseif(method_exists($this->exportService, $method)){
                    $csvRow[$key] = $this->exportService->$method($user);
                }
            }
            if (count($csvRow) > 0 && $handle) {
                fputs($handle,implode($this->exportService->csvSeparator,$csvRow).PHP_EOL);
//                fputcsv($handle, $csvRow,$this->exportService->csvSeparator);
            }
        }
        }
        fclose($handle);
        //compresser le fichier compréssé
        $this->exportService->create_zip(array($this->container->getParameter('rep_export') . "/" . $filename),$this->container->getParameter('rep_export') . "/" . $filename.'.zip', true);
        //supprimer le fichier non compressé
        unlink($this->container->getParameter('rep_export') . "/" . $filename);
    }
    public function getJaccomplisLastConnectionDate($user){
        if($user){
            $lastLogin=$user->lastLogin;//on vas importer cette valeur car pour chaque connexion le token se change donc l'entité subira un update
            $lastLogin=date('Ymd H:m:s',strtotime($lastLogin));
            return $lastLogin;
        }
        else return false;
    }
    public function getJanrainId($user){
        return $user->uuid;
    }
    public function getUsersFromJanrain(){
        //création d'un contexte d'appel de type POST
        //for more details http://developers.janrain.com/rest-api/methods/user-data/entity/find/
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
            )
        );
        $context = stream_context_create($opts);
        $janrainParams=$this->container->getParameter('janrain_params');
        $today=date('Y-m-d 00:00:00');
        $janrainFilters['filter']="lastLogin >'".$today."'";
        $janrainAttributes['attributes']='["uuid","lastLogin"]';
        $janrainParams=array_merge($janrainParams,$janrainAttributes,$janrainFilters);
        $fields_string_urlified = (is_array($janrainParams)) ? http_build_query($janrainParams) : $janrainParams;
        $postJanrain=$this->container->getParameter('janrain_uri').'.find'.'?'.$fields_string_urlified;
        //Utilisation du contexte dans l'appel
        $users = file_get_contents($postJanrain ,false,$context);
        return json_decode($users);
    }
}