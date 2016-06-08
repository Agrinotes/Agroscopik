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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Farm controller.
 *
 * @Security("has_role('ROLE_USER)")
 * @Route("/farm")
 */
class FarmController extends Controller
{
    /**
     * List all Farm entities
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/list")
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
     * @Route("/new", name="farm_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        // If current user already have a farm, redirect it to his farm
        if ($this->getUser()->getFarm() instanceof Farm) {
            return $this->redirectToRoute('plot_index');
        }

        // Create a farm
        $farm = new Farm();

        // Grant ROLE_FARMER to current user
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->addRole("ROLE_FARMER");
        $em->persist($user);
        $em->flush();

        // Force refresh of user roles
        $token = $this->get('security.token_storage')->getToken()->setAuthenticated(false);

        // Set Farmer on created farm to make it easier to retrieve later
        $farm->setFarmer($user);

        // Create form and handle it
        $form = $this->createForm('AppBundle\Form\FarmType', $farm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Store Farm in database and update User Roles
            $em = $this->getDoctrine()->getManager();
            $em->persist($farm);
            $em->flush();

            // Create the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($farm);
            $acl = $aclProvider->createAcl($objectIdentity);

            // Retrieve the security identity of the current user
            $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());

            // Create Access Mask for current user
            $builder = new MaskBuilder();
            $builder
                ->add('create')
                ->add('view')
                ->add('edit');
            $mask = $builder->get();

            // Grant access to current user
            $acl->insertObjectAce($securityIdentity, $mask);

            // Grant full access to administrators
            $securityIdentity = new RoleSecurityIdentity('ROLE_ADMIN');
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_MASTER);

            // Update ACL
            $aclProvider->updateAcl($acl);

            return $this->redirectToRoute('farm_show', array('id' => $farm->getId()));
        }

        return $this->render('AppBundle:farm:new.html.twig', array(
            'farm' => $farm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Farm entity.
     *
     * @Route("/{id}", name="farm_show")
     * @Method("GET")
     * @Security("is_granted('VIEW', farm)")
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
     * @Route("/{id}/edit", name="farm_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('EDIT', farm)")
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
     * @Route("/delete/{id}", name="farm_delete")
     * @Method("DELETE")
     * @Security("is_granted('DELETE', farm)")
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