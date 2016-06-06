<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Farm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 *
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/farm/list")
     */
    public function farmListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $farms = $em->getRepository('AppBundle:Farm')->findAll();

        return $this->render('AppBundle:admin:farm_list.html.twig',array(
            'farms' => $farms
        ));
    }
}
