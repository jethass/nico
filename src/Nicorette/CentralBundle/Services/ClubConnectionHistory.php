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
class ClubConnectionHistory
{
    private $em;
    private $container;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }

    public function ExportClubConnectionHistory(){
        $filename=$this->createCsvFile('ClubConnectionHistory','club');
    }

}