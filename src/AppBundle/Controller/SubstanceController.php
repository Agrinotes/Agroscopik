<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Substance;
use AppBundle\Form\SubstanceType;

/**
 * Substance controller.
 *
 * @Route("/substance")
 */
class SubstanceController extends Controller
{
    /**
     * Lists all Substance entities.
     *
     * @Route("/", name="substance_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $substances = $em->getRepository('AppBundle:Substance')->findAll();

        return $this->render('substance/index.html.twig', array(
            'substances' => $substances,
        ));
    }

    /**
     * Creates a new Substance entity.
     *
     * @Route("/new", name="substance_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $substance = new Substance();
        $form = $this->createForm('AppBundle\Form\SubstanceType', $substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($substance);
            $em->flush();

            return $this->redirectToRoute('substance_show', array('id' => $substance->getId()));
        }

        return $this->render('substance/new.html.twig', array(
            'substance' => $substance,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Substance entity.
     *
     * @Route("/{id}", name="substance_show")
     * @Method("GET")
     */
    public function showAction(Substance $substance)
    {
        $deleteForm = $this->createDeleteForm($substance);

        return $this->render('substance/show.html.twig', array(
            'substance' => $substance,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Substance entity.
     *
     * @Route("/{id}/edit", name="substance_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Substance $substance)
    {
        $deleteForm = $this->createDeleteForm($substance);
        $editForm = $this->createForm('AppBundle\Form\SubstanceType', $substance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($substance);
            $em->flush();

            return $this->redirectToRoute('substance_edit', array('id' => $substance->getId()));
        }

        return $this->render('substance/edit.html.twig', array(
            'substance' => $substance,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Substance entity.
     *
     * @Route("/{id}", name="substance_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Substance $substance)
    {
        $form = $this->createDeleteForm($substance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($substance);
            $em->flush();
        }

        return $this->redirectToRoute('substance_index');
    }

    /**
     * Creates a form to delete a Substance entity.
     *
     * @param Substance $substance The Substance entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Substance $substance)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('substance_delete', array('id' => $substance->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
