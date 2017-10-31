<?php

namespace Nicorette\ApiBundle\Controller;

use Nicorette\CentralBundle\Entity\Judgment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View AS FOSView;
use Nicorette\CentralBundle\Entity\QuizAnswer;

/**
 * controlleur pour la gestion des avis des utilisateur
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */

class JudgmentController extends Controller
{

	/**
	 * @Post("/judgment/{token}", name="set_judgment_for_application", options={ "method_prefix" = false })
	 * @ApiDoc(
	 *  description="Enrégistrer les avis d'un utilisateur",
     *  requirements={{"name"="_format","dataType"="","requirement"="json","description"=""}},
	 *  parameters={
     *      {"name"="uuid", "dataType"="string", "required"=true, "description"="janrain user id"},
     *      {"name"="token", "dataType"="string", "required"=false, "description"="janrain user token"},
	 *      {"name"="contain", "dataType"="integer", "required"=true, "description"="L'avis du patient sur le contenue du programme"},
	 *      {"name"="duration", "dataType"="integer", "required"=true, "description"="L'avis du patient sur la durée du programme"},
	 *      {"name"="frequency", "dataType"="integer", "required"=true, "description"="L'avis du patient sur la fréquence du programme"},
	 *      {"name"="personalization", "dataType"="integer", "required"=true, "description"="L'avis du patient sur la personnalisation du programme"},
	 *      {"name"="useful", "dataType"="integer", "required"=true, "description"="L'avis du patient sur l'utilité du programme"},
     *      {"name"="deleteAccount", "dataType"="boolean", "required"=true, "description"="Indique si le patient souhaite supprimer sont compte nicorette ou non"},
	 *      {"name"="quit", "dataType"="integer", "required"=true, "description"="Arréter le programme de nicorette"}
	 *  },
     *  output="['success'] = true si toute est valide ou ['success'] = false avec un message descriptif sur le traitement."
	 * )
	 *
	 */
	public function saveJudgmentAction(Request $request,$token)
    {
        $view = FOSView::create();
        $em = $this->getDoctrine()->getManager();
        if($token && $user = $em->getRepository('NicoretteCentralBundle:Patient')->findOneByToken($token)){
            $judgment=new Judgment();
            $judgment->setData($request,$user);
            $contract=$em->getRepository('NicoretteCentralBundle:Contract')->getLastContractsByUser($user);
            $contract->setQuit($request->get('quit'));
            $user->addJudgment($judgment);
            $em->persist($user);
            $em->persist($contract);
            $em->persist($judgment);
            $em->flush();
            $userTools=$this->get('user_tools_service');
            if(($request->get('deleteAccount'))==true){
                $em->remove($user);
                // supprimer le compte de l'api de janrain
                $userTools->deleteUserFromJanrain($user->getJanrainId());
                $em->flush();
                $result['success'] = true;
                $result['data']['Mes_alertes'] = 'Votre avis est ajouter avec succès';
            }elseif(($request->get('deleteAccount'))==false){
                $clonedUser=$userTools->handlyClone($user);
                $em->remove($user);
                $em->flush();
                $em->persist($clonedUser);
                $em->flush();
                $result['success'] = true;
                $result['data']['msg'] = 'Votre programme est arrèté avec succès';
                $result['data']['popUp'] = true;//afficher un pop up pour l'utilisateur "Vous avez mis fin à votre dernière tentative d'arrêt. Souhaitez-vous eassayez à nouveau ?"

            }
        }else{
            $result['success'] = false;
            $result['errors'][] = 'Token invalide ou inéxistant';
        }

        $view->setStatusCode(200)->setData($result);
        return $view;
    }

}
