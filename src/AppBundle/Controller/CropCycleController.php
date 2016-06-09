<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CropCycle;
use AppBundle\Form\CropCycleType;

/**
 * CropCycle controller.
 *
 */
class CropCycleController extends Controller
{
    /**
     * Lists all CropCycle entities.
     *
     * @Route("/cropcycle", name="cropcycle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cropCycles = $em->getRepository('AppBundle:CropCycle')->findAll();

        return $this->render('cropcycle/index.html.twig', array(
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

            return $this->redirectToRoute('cropcycle_show', array('id' => $cropCycle->getId()));
        }

        return $this->render('cropcycle/new.html.twig', array(
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
     */
    public function showAction(CropCycle $cropCycle)
    {
        $deleteForm = $this->createDeleteForm($cropCycle);

        return $this->render('cropcycle/show.html.twig', array(
            'cropCycle' => $cropCycle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CropCycle entity.
     *
     * @Route("/cropcycle/{id}/edit", name="cropcycle_edit")
     * @Method({"GET", "POST"})
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

            return $this->redirectToRoute('cropcycle_edit', array('id' => $cropCycle->getId()));
        }

        return $this->render('cropcycle/edit.html.twig', array(
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
     */
    public function deleteAction(Request $request, CropCycle $cropCycle)
    {
        $form = $this->createDeleteForm($cropCycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cropCycle);
            $em->flush();
        }

        return $this->redirectToRoute('cropcycle_index');
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
            ->getForm()
        ;
    }
}
