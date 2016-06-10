<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Intervention;
use AppBundle\Form\InterventionType;

/**
 * Intervention controller.
 *
 * @Route("/intervention")
 */
class InterventionController extends Controller
{
    /**
     * Lists all Intervention entities.
     *
     * @Route("/", name="intervention_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $interventions = $em->getRepository('AppBundle:Intervention')->findAll();

        return $this->render('@App/intervention/index.html.twig', array(
            'interventions' => $interventions,
        ));
    }

    /**
     * Creates a new Intervention entity.
     *
     * @Route("/new", name="intervention_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $intervention = new Intervention();
        $form = $this->createForm('AppBundle\Form\InterventionType', $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intervention);
            $em->flush();

            return $this->redirectToRoute('intervention_show', array('id' => $intervention->getId()));
        }

        return $this->render('@App/intervention/new.html.twig', array(
            'intervention' => $intervention,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Intervention entity.
     *
     * @Route("/{id}", name="intervention_show")
     * @Method("GET")
     */
    public function showAction(Intervention $intervention)
    {
        $deleteForm = $this->createDeleteForm($intervention);

        return $this->render('@App/intervention/show.html.twig', array(
            'intervention' => $intervention,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Intervention entity.
     *
     * @Route("/{id}/edit", name="intervention_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Intervention $intervention)
    {
        $deleteForm = $this->createDeleteForm($intervention);
        $editForm = $this->createForm('AppBundle\Form\InterventionType', $intervention);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intervention);
            $em->flush();

            return $this->redirectToRoute('intervention_show', array('id' => $intervention->getId()));
        }

        return $this->render('@App/intervention/edit.html.twig', array(
            'intervention' => $intervention,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Intervention entity.
     *
     * @Route("/{id}", name="intervention_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Intervention $intervention)
    {
        $form = $this->createDeleteForm($intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($intervention);
            $em->flush();
        }

        return $this->redirectToRoute('intervention_index');
    }

    /**
     * Creates a form to delete a Intervention entity.
     *
     * @param Intervention $intervention The Intervention entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Intervention $intervention)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('intervention_delete', array('id' => $intervention->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
