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

class MyPointsController extends Controller
{
    /**
     * @Get("/mypoints/{token}", name="user_mypoints")
     * @ApiDoc(
	 *  description="Récupérer les données de 'Mes points' ",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
	 *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
	 *  }
	 * )
     */
    public function indexAction($token)
    {
    	$view = FOSView::create();
    	$mypoints_service = $this->get('nicorette.economy_service');
    	$result = $mypoints_service->getDetailsPoint($token);
        $view->setStatusCode(200)->setData($result);
        return $view;
    }
}
