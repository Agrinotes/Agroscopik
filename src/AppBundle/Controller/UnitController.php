<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Unit;
use AppBundle\Form\UnitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Unit controller.
 *
 * @Route("/unit")
 * @Security("has_role('ROLE_ADMIN')")
 */
class UnitController extends Controller
{
    /**
     * Lists all Unit entities.
     *
     * @Route("/", name="unit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $units = $em->getRepository('AppBundle:Unit')->findAll();

        return $this->render('unit/index.html.twig', array(
            'units' => $units,
        ));
    }

    /**
     * Creates a new Unit entity.
     *
     * @Route("/new", name="unit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $unit = new Unit();
        $form = $this->createForm('AppBundle\Form\UnitType', $unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unit);
            $em->flush();

            return $this->redirectToRoute('unit_show', array('id' => $unit->getId()));
        }

        return $this->render('unit/new.html.twig', array(
            'unit' => $unit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Unit entity.
     *
     * @Route("/{id}", name="unit_show")
     * @Method("GET")
     */
    public function showAction(Unit $unit)
    {
        $deleteForm = $this->createDeleteForm($unit);

        return $this->render('unit/show.html.twig', array(
            'unit' => $unit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Unit entity.
     *
     * @Route("/{id}/edit", name="unit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Unit $unit)
    {
        $deleteForm = $this->createDeleteForm($unit);
        $editForm = $this->createForm('AppBundle\Form\UnitType', $unit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unit);
            $em->flush();

            return $this->redirectToRoute('unit_edit', array('id' => $unit->getId()));
        }

        return $this->render('unit/edit.html.twig', array(
            'unit' => $unit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Unit entity.
     *
     * @Route("/{id}", name="unit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Unit $unit)
    {
        $form = $this->createDeleteForm($unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($unit);
            $em->flush();
        }

        return $this->redirectToRoute('unit_index');
    }

    /**
     * Creates a form to delete a Unit entity.
     *
     * @param Unit $unit The Unit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Unit $unit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unit_delete', array('id' => $unit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
