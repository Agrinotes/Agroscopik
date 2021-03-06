<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Farm;
use AppBundle\Form\FarmType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Farm controller.
 *
 * @Security("has_role('ROLE_USER)")
 */
class FarmController extends Controller
{

    /**
     * Finds and displays current user Farm entity.
     *
     * @Route("/farm", name="farm_show_current")
     * @Security("has_role('ROLE_FARMER')")
     * @Method("GET")
     *
     */
    public function showCurrentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Farm');
        $id = $this->getUser()->getFarm()->getId();
        $farm = $repository->find($id);

        $repository2 = $em->getRepository('AppBundle:Action');

        $actions = $repository2->findForFarm($id);

        $deleteForm = $this->createDeleteForm($farm);

        return $this->render('AppBundle:farm:show.html.twig', array(
            'farm' => $farm,
            'delete_form' => $deleteForm->createView(),
            'actions'=>$actions,
        ));
    }

    /**
     * Show current user Dashboard
     *
     * @Route("/dashboard", name="dashboard")
     * @Security("has_role('ROLE_FARMER')")
     * @Method("GET")
     *
     */
    public function dashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Farm');
        $id = $this->getUser()->getFarm()->getId();
        $farm = $repository->find($id);

        $deleteForm = $this->createDeleteForm($farm);

        return $this->render('AppBundle:dashboard:dashboard.html.twig', array(
            'farm' => $farm,
            'delete_form' => $deleteForm->createView(),

        ));
    }


    /**
     * Finds and displays current user Farm entity.
     *
     * @Route("/map", name="farm_map")
     * @Security("has_role('ROLE_FARMER')")
     * @Method("GET")
     *
     */
    public function mapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Farm');
        $id = $this->getUser()->getFarm()->getId();
        $farm = $repository->find($id);

        $deleteForm = $this->createDeleteForm($farm);

        return $this->render('AppBundle:farm:map.html.twig', array(
            'farm' => $farm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays current user calednar entity.
     *
     * @Route("/calendar", name="farm_calendar")
     * @Security("has_role('ROLE_FARMER')")
     * @Method("GET")
     *
     */
    public function calendarAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Farm');
        $id = $this->getUser()->getFarm()->getId();
        $farm = $repository->find($id);

        $repository2 = $em->getRepository('AppBundle:Action');

        $actions = $repository2->findForFarm($id);

        return $this->render('AppBundle:farm:calendar.html.twig', array(
            'farm' => $farm,
            'actions' => $actions,
        ));
    }


    /**
     * List all Farm entities
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/farm/list")
     * @param Request $request
     * @return Response
     */
    public function farmListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $farms = $em->getRepository('AppBundle:Farm')->findAll();

        return $this->render('AppBundle:admin:farm_list.html.twig', array(
            'farms' => $farms
        ));
    }

    /**
     * Creates a new Farm entity.
     *
     * @Route("/farm/new", name="farm_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        // If current user already have a farm, redirect it to his farm
        if ($this->getUser()->getFarm() instanceof Farm) {
            return $this->redirectToRoute('farm_show_current');
        }

        // Get entity manager
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        // Create a farm
        $farm = new Farm();
        $farm->setFarmer($user);
        $farm->setName('Ferme de '.$user->getFullName());
        $em->persist($farm);

        // Grant ROLE_FARMER to current user
        $user->addRole("ROLE_FARMER");
        $em->persist($user);
        $em->flush();

        // Create the ACL
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($farm);
        $acl = $aclProvider->createAcl($objectIdentity);

        // Retrieve the security identity of the current user
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // Create Access Mask for current user
        $builder = new MaskBuilder();
        $builder
            ->add('create')
            ->add('view')
            ->add('edit');
        $mask = $builder->get();

        // Grant access to current user
        $acl->insertObjectAce($securityIdentity, $mask);

        // Update ACL
        $aclProvider->updateAcl($acl);

        // Refresh user roles
        $token = new UsernamePasswordToken(
            $user,
            null,
            'main',
            $user->getRoles()
        );
        $this->container->get('security.token_storage')->setToken($token);


        // Create form and handle it
        $form = $this->createForm('AppBundle\Form\FarmType', $farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Store Farm in database
            $em = $this->getDoctrine()->getManager();
            $em->persist($farm);
            $em->flush();

            return $this->redirectToRoute('farm_show_current', array('id' => $farm->getId()));
        }

        return $this->render('AppBundle:farm:new.html.twig', array(
            'farm' => $farm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Farm entity.
     *
     * @Route("/farm/{id}", name="farm_show")
     * @Method("GET")
     * @Security("is_granted('VIEW', farm) or has_role('ROLE_ADMIN')")
     *
     */
    public function showAction(Farm $farm)
    {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Farm');

        $deleteForm = $this->createDeleteForm($farm);

        return $this->render('AppBundle:farm:show.html.twig', array(
            'farm' => $farm,
            'delete_form' => $deleteForm->createView(),
        ));
    }




    /**
     * Displays a form to edit an existing Farm entity.
     *
     * @Route("/farm/{id}/edit", name="farm_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('EDIT', farm) or has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Farm $farm)
    {
        $deleteForm = $this->createDeleteForm($farm);
        $editForm = $this->createForm('AppBundle\Form\FarmType', $farm);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($farm);
            $em->flush();

            return $this->redirectToRoute('farm_show', array('id' => $farm->getId()));
        }

        return $this->render('AppBundle:farm:edit.html.twig', array(
            'farm' => $farm,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Farm entity.
     *
     * @Route("/farm/delete/{id}", name="farm_delete")
     * @Method("DELETE")
     * @Security("is_granted('DELETE', farm) or has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Farm $farm)
    {
        $form = $this->createDeleteForm($farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($farm);
            $em->flush();
        }

        return $this->redirectToRoute('something_here');
    }

    /**
     * Creates a form to delete a Farm entity.
     *
     * @param Farm $farm The Farm entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Farm $farm)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('farm_delete', array('id' => $farm->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
