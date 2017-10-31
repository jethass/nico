<?php

namespace Nicorette\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View AS FOSView;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;

class CalendarController extends Controller
{
    /**
     * @Get("/calendar/{token}", name="user_calendar", options={ "method_prefix" = false })
     * @ApiDoc(
	 *  description="Récupérer les données du calendrier",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
	 *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"}
	 *  }
	 * )
     */
    public function indexAction($token)
    {
    	$view = FOSView::create();
    	$calendar_service = $this->get('nicorette.calendar_service');
    	$result = $calendar_service->getData($token);
        $view->setStatusCode(200)->setData($result);
        return $view;
    }
}
