<?php

namespace Nicorette\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Put;
use Nicorette\CentralBundle\Entity\Contact;
use Nicorette\CentralBundle\Entity\Contract;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;

/**
 * controlleur pour la gestion des parrains d'un utilisateur
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */

class SponsoringController extends Controller
{

    /**
	 * @Post("/sponsoring/new", name="add_new_sponsor", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="Add a new sponsor",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"},
     *      {"name"="name", "dataType"="string", "required"=true, "description"="the sponsor name"},
     *      {"name"="email", "dataType"="string", "required"=true, "description"="the sponsor email"},
     *      {"name"="phone", "dataType"="string", "required"=true, "description"="the sponsor phone"}
	 *  }
	 * )
	 *
	 */
	public function newAction(Request $request)
    {
        $view = FOSView::create();
        $tools = $this->get('nicorette.tools');
        $em = $this->getDoctrine()->getManager();
                if($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))){
                    $contact=new Contact();
                    $contact->setData($request);
                    $contact->setPatient($user);
                    $user->addContact($contact);
                    if(!count($this->get('validator')->validate($contact))){
                        $em->persist($user);

                        $tools->addPoint('parrain_create', $user);
                        $em->flush();

                        $result['success'] = true;
                        $result['data']['contact'] = 'Contact ajouté avec succès';
                    }else{
                        $result['success'] = false;
                        $result['errors'][] = 'Données invalides ou manquantes';
                    }
                }else{
                    $result['success'] = false;
                    $result['errors'][] = 'Token invalide ou inéxistant';
                }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
	 * @Delete("/sponsoring/delete/{token}", name="delete_sponsor", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="Delete a sponsor",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="contact_id", "dataType"="integer", "required"=true, "description"="sponsor id"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
	 *  }
	 * )
	 *
	 */
	public function deleteAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
                if($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))){
                    $contact=$em->getRepository('NicoretteCentralBundle:Contact')->findOneById($request->get('contact_id'));
                    
                    $toolsService = $this->get('nicorette.tools');
                    $toolsService->addPoint('parrain_create', $user, true);
                    
                    $user->removeContact($contact);
                    $em->remove($contact);
                    $em->persist($user);
                    $em->flush();
                    $result['success'] = true;
                    $result['data']['contact'] = 'Contact supprimer avec succès';
                }else{
                    $result['success'] = false;
                    $result['errors'][] = 'Token invalide ou inéxistant';
                }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }

    /**
     * @Put("/sponsoring/update/{token}", name="update_sponsor", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Update a sponsor",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="contact_id", "dataType"="integer", "required"=true, "description"="sponsor id"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"},
     *      {"name"="name", "dataType"="string", "required"=true, "description"="the sponsor name"},
     *      {"name"="email", "dataType"="string", "required"=true, "description"="the sponsor email"},
     *      {"name"="phone", "dataType"="string", "required"=true, "description"="the sponsor phone"}
     *  }
     * )
     *
     */
    public function updateAction(Request $request)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if($request->get('token') && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($request->get('token'))){
            $contact=$em->getRepository('NicoretteCentralBundle:Contact')->findOneById($request->get('contact_id'));
            $contact->setData($request);
            if(!count($this->get('validator')->validate($contact))){
                $em->persist($user);
                $em->flush();
                $result['success'] = true;
                $result['data']['contact'] = 'Contact modifier avec succès';
            }else{
                $result['success'] = false;
                $result['errors'][] = 'Données invalides ou manquantes';
            }
        }else{
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inéxistant';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }


    /**
     * @Get("/sponsoring/{token}", name="get_list_sponsor", options={ "method_prefix" = false })
     * @ApiDoc(
     *  description="Lister les parrains",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
     *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="token", "dataType"="string", "required"=true, "description"="janrain user token"}
     *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
     * )
     *
     */
    public function indexAction(Request $request,$token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if($token && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token)){
            $contacts=$user->getContacts();
            $result['success'] = true;
            $result['data']['contacts'] = $contacts;
        }else{
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inéxistant';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }
}
