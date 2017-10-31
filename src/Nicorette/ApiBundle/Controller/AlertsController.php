<?php

namespace Nicorette\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;
/**
 * controlleur pour la sauvegarde des réponses des utilisateurs pour les alertes
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class AlertsController extends Controller
{

	/**
	 * @Post("/alerts/save/{token}", name="set_alerts_for_patient", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="Enrégistrer les réponses d'un utilisateur",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
	 *      {"name"="club_alerts", "dataType"="boolean", "required"=true, "description"="Si le patient souhaite recevoir des alertes du club des Incroyables"},
	 *      {"name"="johnson_alerts", "dataType"="boolean", "required"=true, "description"="Si le patient souhaite recevoir les informations du groupe Johnson & Johnson."},
	 *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
	 *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
	 * )
	 *
	 */
	public function saveAlertsAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))){
            $request->get('club_alerts')?$user->setClubAlerts($request->get('club_alerts')):$user->setClubAlerts(0);
            $request->get('johnson_alerts')?$user->setJohnsonAlerts($request->get('johnson_alerts')):$user->setJohnsonAlerts(0);
            $em->persist($user);
            $em->flush();
            $result['success'] = true;
            $result['data']['Mes_alertes'] = 'Modification avec succès';
        }else{
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inéxistant';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Put("/alerts/update/{token}", name="update_alerts_for_patient", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Mettre a jours les réponses d'un utilisateur pour la rubrique mes alertes",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="club_alerts", "dataType"="boolean", "required"=true, "description"="Si le patient souhaite recevoir des alertes du club des Incroyables"},
     *      {"name"="johnson_alerts", "dataType"="boolean", "required"=true, "description"="Si le patient souhaite recevoir les informations du groupe Johnson & Johnson."},
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
     * )
     *
     */
    public function updateAlertsAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))){
            $request->get('club_alerts')?$user->setClubAlerts($request->get('club_alerts')):$user->setClubAlerts(0);
            $request->get('johnson_alerts')?$user->setJohnsonAlerts($request->get('johnson_alerts')):$user->setJohnsonAlerts(0);
            $em->persist($user);
            $em->flush();
            $result['success'] = true;
            $result['data']['Mes_alertes'] = 'Modification avec succès';
        }else{
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inéxistant';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }


    /**
     * @Get("/alerts/{token}", name="get_alerts_for_patient", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="récupérer les réponses d'un utilisateur pour la rubrique mes alertes",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
     *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
     * )
     *
     */
    public function getAlertsAction(Request $request,$token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if($token && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token)){
            $result['data']['Mes_alertes']['club_alerts'] = $user->isClubAlerts();
            $result['data']['Mes_alertes']['johnson_alerts'] = $user->isJohnsonAlerts();
            $result['success'] = true;
        }else{
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inéxistant';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    
}
