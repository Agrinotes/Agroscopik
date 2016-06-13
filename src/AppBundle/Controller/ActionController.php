<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CropCycle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Action;
use AppBundle\Form\ActionType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Action controller.
 *
 * @Security("has_role('ROLE_USER')")
 * @Route("/")
 */
class ActionController extends Controller
{
    /**
     * Lists all Action entities.
     *
     * @Route("/cropcycle/{id}/action", name="action_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $cropCycle = $this->getDoctrine()->getManager()->getRepository('AppBundle:CropCycle')->find($id);

        $actions = $em->getRepository('AppBundle:Action')->findAll();//for current cropCycle

        return $this->render('@App/action/index.html.twig', array(
            'actions' => $actions,
            'cropCycle' => $cropCycle,
        ));
    }

    /**
     * Creates a new Action entity.
     *
     * @Route("/cropcycle/{id}/action/new", name="action_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $action = new Action();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        // Get current cropCycle
        $cropCycle = $em->getRepository('AppBundle:CropCycle')->find($id);

        // Check for edit access
        $authorizationChecker = $this->get('security.authorization_checker');
        if (false === $authorizationChecker->isGranted('EDIT', $cropCycle)) {
            throw new AccessDeniedException();
        }

        // Link this action to current crop cycle
        $cropCycle->addAction($action); // Which also setCropcycle($this) on $action

        $form = $this->createForm('AppBundle\Form\ActionType', $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current Action $action
            $objectIdentity = ObjectIdentity::fromDomainObject($action);
            $acl = $aclProvider->createAcl($objectIdentity);

            // Retrieve the security identity of the current user
            $securityIdentity = UserSecurityIdentity::fromAccount($this->getUser());

            // Create Access Mask
            $builder = new MaskBuilder();
            $builder
                ->add('view')
                ->add('edit')
                ->add('delete');
            $mask = $builder->get();

            // Insert Object Access Entry
            $acl->insertObjectAce($securityIdentity, $mask);

            // Update ACL
            $aclProvider->updateAcl($acl);

            return $this->redirectToRoute('cropcycle_show', array('id' => $action->getCropCycle()->getId()));
        }

        return $this->render('@App/action/new.html.twig', array(
            'cropCycle' => $cropCycle,
            'action' => $action,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Action entity.
     *
     * @Route("/action/{id}", name="action_show")
     * @Method("GET")
     */
    public function showAction(Action $action)
    {
        $deleteForm = $this->createDeleteForm($action);

        return $this->render('@App/action/show.html.twig', array(
            'action' => $action,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Action entity.
     *
     * @Route("/action/{id}/edit", name="action_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Action $action)
    {
        $deleteForm = $this->createDeleteForm($action);
        $editForm = $this->createForm('AppBundle\Form\ActionType', $action);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();

            return $this->redirectToRoute('action_show', array('id' => $action->getId()));
        }

        return $this->render('@App/action/edit.html.twig', array(
            'action' => $action,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Action entity.
     *
     * @Route("/action/{id}", name="action_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Action $action)
    {
        $form = $this->createDeleteForm($action);
        $form->handleRequest($request);

        $id = $action->getCropCycle()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($action);
            $em->flush();
        }

        return $this->redirectToRoute('cropcycle_show', array('id' => $id));
    }

    /**
     * Creates a form to delete a Action entity.
     *
     * @param Action $action The Action entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Action $action)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('action_delete', array('id' => $action->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
