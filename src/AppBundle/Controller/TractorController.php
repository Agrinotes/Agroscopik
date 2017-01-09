<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\TractorType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Farm;


/**
 * Tractor controller.
 *
 * @Security("has_role('ROLE_USER')")
 * @Route("/tractor")
 */
class TractorController extends Controller
{
    /**
     * Lists all Tractor entities for current Farm
     *
     * @Route("/", name="tractor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm()->getId();

        $tractors = $em->getRepository('AppBundle:Tractor')->findAllForCurrentFarm($farm);

        return $this->render('@App/tractor/index.html.twig', array(
            'tractors' => $tractors,
        ));
    }

    /**
     * Creates a new Tractor entity.
     *
     * @Route("/new", name="tractor_new")
     * @Security("is_granted('ROLE_FARMER')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tractor = new Tractor();

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $farm = $this->getUser()->getFarm();
        $farm->addTractor($tractor);

        $form = $this->createForm('AppBundle\Form\TractorType', $tractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tractor);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current Action $action
            $objectIdentity = ObjectIdentity::fromDomainObject($tractor);
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

            return $this->redirectToRoute('tractor_index');
        }

        return $this->render('@App/tractor/new.html.twig', array(
            'tractor' => $tractor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tractor entity.
     *
     * @Security("is_granted('VIEW', tractor) or is_granted('ROLE_ADMIN')")
     * @Route("/{id}", name="tractor_show")
     * @Method("GET")
     */
    public function showAction(Tractor $tractor)
    {
        $deleteForm = $this->createDeleteForm($tractor);

        return $this->render('@App/tractor/show.html.twig', array(
            'tractor' => $tractor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tractor entity.
     *
     * @Security("is_granted('EDIT', tractor) or is_granted('ROLE_ADMIN')")
     * @Route("/{id}/edit", name="tractor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tractor $tractor)
    {
        $deleteForm = $this->createDeleteForm($tractor);
        $editForm = $this->createForm('AppBundle\Form\TractorType', $tractor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tractor);
            $em->flush();

            return $this->redirectToRoute('tractor_index');
        }

        return $this->render('@App/tractor/edit.html.twig', array(
            'tractor' => $tractor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tractor entity.
     *
     * @Security("is_granted('DELETE', tractor) or is_granted('ROLE_ADMIN')")
     * @Route("/{id}/delete", name="tractor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tractor $tractor)
    {
        $form = $this->createDeleteForm($tractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tractor);
            $em->flush();
        }

        return $this->redirectToRoute('tractor_index');
    }

    /**
     * Deletes a Tractor entity.
     *
     * @Security("is_granted('DELETE', tractor) or is_granted('ROLE_ADMIN')")
     * @Route("/{id}/delete/ajax", name="tractor_delete_ajax")
     */
    public function deleteAjaxAction(Request $request, Tractor $tractor)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tractor);
            $em->flush();

        return new JsonResponse(array('data' => 'this is a json response'));
    }

    /**
     * Creates a form to delete a Tractor entity.
     *
     * @param Tractor $tractor The Tractor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tractor $tractor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tractor_delete', array('id' => $tractor->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
