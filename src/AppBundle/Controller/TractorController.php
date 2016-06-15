<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tractor;
use AppBundle\Form\TractorType;

/**
 * Tractor controller.
 *
 * @Route("/tractor")
 */
class TractorController extends Controller
{
    /**
     * Lists all Tractor entities.
     *
     * @Route("/", name="tractor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tractors = $em->getRepository('AppBundle:Tractor')->findAll();

        return $this->render('tractor/index.html.twig', array(
            'tractors' => $tractors,
        ));
    }

    /**
     * Creates a new Tractor entity.
     *
     * @Route("/new", name="tractor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tractor = new Tractor();
        $form = $this->createForm('AppBundle\Form\TractorType', $tractor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tractor);
            $em->flush();

            return $this->redirectToRoute('tractor_show', array('id' => $tractor->getId()));
        }

        return $this->render('tractor/new.html.twig', array(
            'tractor' => $tractor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tractor entity.
     *
     * @Route("/{id}", name="tractor_show")
     * @Method("GET")
     */
    public function showAction(Tractor $tractor)
    {
        $deleteForm = $this->createDeleteForm($tractor);

        return $this->render('tractor/show.html.twig', array(
            'tractor' => $tractor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tractor entity.
     *
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

            return $this->redirectToRoute('tractor_edit', array('id' => $tractor->getId()));
        }

        return $this->render('tractor/edit.html.twig', array(
            'tractor' => $tractor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tractor entity.
     *
     * @Route("/{id}", name="tractor_delete")
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
            ->getForm()
        ;
    }
}
