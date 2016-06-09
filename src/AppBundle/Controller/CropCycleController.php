<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CropCycle;
use AppBundle\Form\CropCycleType;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * CropCycle controller.
 *
 * @Security("has_role('ROLE_FARMER')")
 */
class CropCycleController extends Controller
{
    /**
     * Lists all CropCycle entities
     * .
     * @Route("/plot/{id}/cropcycles", name="cropcycle_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        // Get current plot
        $plot = $this->getDoctrine()->getManager()->getRepository('AppBundle:Plot')->find($id);

        $cropCycles = $em->getRepository('AppBundle:CropCycle')->findBy(array('plot' => $plot));

        return $this->render('@App/cropcycle/index.html.twig', array(
            'plot' => $plot,
            'cropCycles' => $cropCycles,
        ));
    }

    /**
     * Creates a new CropCycle entity.
     *
     * @Route("/plot/{id}/cropcycle/new", name="cropcycle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $cropCycle = new CropCycle();

        // Get current plot
        $plot = $this->getDoctrine()->getManager()->getRepository('AppBundle:Plot')->find($id);
        $plot->addCropCycle($cropCycle); // Which also setPlot($plot) on $cropCycle

        // Get Entity Manager
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('AppBundle\Form\CropCycleType', $cropCycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cropCycle);
            $em->flush();

            // Call ACL service
            $aclProvider = $this->get('security.acl.provider');

            // Create the ACL for current CropCycle $cropCycle
            $objectIdentity = ObjectIdentity::fromDomainObject($cropCycle);
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

            return $this->redirectToRoute('cropcycle_show', array('id' => $cropCycle->getId()));
        }

        return $this->render('@App/cropcycle/new.html.twig', array(
            'plot' => $plot,
            'cropCycle' => $cropCycle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CropCycle entity.
     *
     * @Route("/cropcycle/{id}", name="cropcycle_show")
     * @Method("GET")
     * @param CropCycle $cropCycle
     * @Security("is_granted('VIEW', cropCycle) or is_granted('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(CropCycle $cropCycle)
    {
        $deleteForm = $this->createDeleteForm($cropCycle);

        return $this->render('@App/cropcycle/show.html.twig', array(
            'cropCycle' => $cropCycle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CropCycle entity.
     *
     * @Route("/cropcycle/{id}/edit", name="cropcycle_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param CropCycle $cropCycle
     * @Security("is_granted('EDIT', cropCycle) or is_granted('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, CropCycle $cropCycle)
    {
        $deleteForm = $this->createDeleteForm($cropCycle);
        $editForm = $this->createForm('AppBundle\Form\CropCycleType', $cropCycle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cropCycle);
            $em->flush();

            return $this->redirectToRoute('cropcycle_show', array('id' => $cropCycle->getId()));
        }

        return $this->render('@App/cropcycle/edit.html.twig', array(
            'cropCycle' => $cropCycle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CropCycle entity.
     *
     * @Route("/cropcycle/{id}", name="cropcycle_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param CropCycle $cropCycle
     * @Security("is_granted('DELETE', cropCycle) or is_granted('ROLE_ADMIN')")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, CropCycle $cropCycle)
    {
        $form = $this->createDeleteForm($cropCycle);
        $form->handleRequest($request);

        $plot_id = $cropCycle->getPlot()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cropCycle);
            $em->flush();
        }

        return $this->redirectToRoute('plot_show', array(
            'id' => $plot_id
        ));
    }

    /**
     * Creates a form to delete a CropCycle entity.
     *
     * @param CropCycle $cropCycle The CropCycle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CropCycle $cropCycle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cropcycle_delete', array('id' => $cropCycle->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
