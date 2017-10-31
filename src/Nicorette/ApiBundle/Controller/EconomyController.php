<?php

namespace Nicorette\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use Nicorette\CentralBundle\Entity\PatientEconomy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;


/**
 * Contrôleur  pour la gestion des économies d'un patient
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */

class EconomyController extends Controller
{


    /**
     * @Post("/economy/save/{token}", name="save_my_economy", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Sauvegarder les economies d'un utilisateur dans les deux cas, ajout et mise à jours",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"},
     *      {"name"="packetPrice", "dataType"="string", "required"=false, "description"="janrain user token"},
     *      {"name"="packetSize", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function saveMyEconomyAction(Request $request,$token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
            if ($user) {
                $userEconomy= $user->getPatientEconomys();
                if(!(count($userEconomy)> 0) && !$userEconomy[0]){
                    $economy= new PatientEconomy();
                }else{
                    $economy=$userEconomy[0];
                }
                $economy->setPaquetSize((integer)$request->get('packetSize'));
                $economy->setPrice($request->get('packetPrice'));
                $economy->setPatient($user);
                $em->Persist($economy);
                $em->flush();
                $result['success'] = true;
                $result['msg'] = 'Mise à jours avec succès.';
            } else {
                $result['success'] = false;
                $result['errors'][] = 'Token invalide';
            }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }
    /**
     * @Delete("/economy/delete/{token}", name="get_my_economy", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Supprimer les réponses de mes économies avec ces retours spécifiques nécessaires",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function removeMyEconomyAction(Request $request,$token){
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);
        if ($user) {
            $userEconomy= $user->getPatientEconomys();
           foreach($userEconomy as $patientEconomy){
                $user->removePatientEconomy($patientEconomy);
                $em->remove($patientEconomy);
            }

            $em->Persist($user);
            $em->flush();
            $result['success'] = true;
            $result['msg'] = 'Mise à jours avec succès.';
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Token invalide';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;}

    /**
     * @Get("/economy/{token}", name="get_my_economy", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Récupérer les réponses de mes économies avec ces retours spécifiques nécessaires",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  }
     * )
     *
     */
    public function getMyEconomyAction(Request $request,$token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token);

        if ($user) {
            $result['success'] = true;
            if ($request->get('token') && $user):
                $userEconomy= $user->getPatientEconomys();
                $result['data']['economy']['packetSize'] =count($userEconomy)>0 && $userEconomy[0]?$userEconomy[0]->getPaquetSize():0;
                $result['data']['economy']['packetPrice'] =count($userEconomy)>0 && $userEconomy[0]?$userEconomy[0]->getPrice():0;
            endif;
        } else {
            $result['success'] = false;
            $result['errors'][] = 'Token invalide';
        }


        $view->setStatusCode(200)->setData($result);
        return $view;
    }


}
