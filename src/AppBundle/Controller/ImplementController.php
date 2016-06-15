<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Implement;
use AppBundle\Form\ImplementType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Implement controller.
 *
 * @Security("has_role('ROLE_USER')")
 * @Route("/implement")
 */
class ImplementController extends Controller
{
    /**
     * Lists all Implement entities.
     *
     * @Route("/", name="implement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm()->getId();

        $implements = $em->getRepository('AppBundle:Implement')->findAllForCurrentFarm($farm);

        return $this->render('@App/implement/index.html.twig', array(
            'implements' => $implements,
        ));
    }

    /**
     * Creates a new Implement entity.
     *
     * @Security("is_granted('ROLE_FARMER')")
     * @Route("/new", name="implement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $implement = new Implement();

        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm();
        $farm->addImplement($implement);

        $form = $this->createForm('AppBundle\Form\ImplementType', $implement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($implement);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current Implement $implement
            $objectIdentity = ObjectIdentity::fromDomainObject($implement);
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

            return $this->redirectToRoute('implement_show', array('id' => $implement->getId()));
        }

        return $this->render('@App/implement/new.html.twig', array(
            'implement' => $implement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Implement entity.
     *
     * @Security("is_granted('VIEW', implement) or is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="implement_show")
     * @Method("GET")
     */
    public function showAction(Implement $implement)
    {
        $deleteForm = $this->createDeleteForm($implement);

        return $this->render('@App/implement/show.html.twig', array(
            'implement' => $implement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Implement entity.
     *
     * @Security("is_granted('EDIT', implement) or is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="implement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Implement $implement)
    {
        $deleteForm = $this->createDeleteForm($implement);
        $editForm = $this->createForm('AppBundle\Form\ImplementType', $implement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($implement);
            $em->flush();

            return $this->redirectToRoute('implement_edit', array('id' => $implement->getId()));
        }

        return $this->render('@App/implement/edit.html.twig', array(
            'implement' => $implement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Implement entity.
     *
     * @Security("is_granted('DELETE', implement) or is_granted('ROLE_ADMIN')")
     * @Route("/{id}/delete", name="implement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Implement $implement)
    {
        $form = $this->createDeleteForm($implement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($implement);
            $em->flush();
        }

        return $this->redirectToRoute('implement_index');
    }

    /**
     * Creates a form to delete a Implement entity.
     *
     * @param Implement $implement The Implement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Implement $implement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('implement_delete', array('id' => $implement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
