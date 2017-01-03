<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Irrigation;
use AppBundle\Form\IrrigationType;

/**
 * Irrigation controller.
 *
 * @Route("/irrigation")
 */
class IrrigationController extends Controller
{
    /**
     * Lists all Irrigation entities.
     *
     * @Route("/", name="irrigation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $irrigations = $em->getRepository('AppBundle:Irrigation')->findAll();

        return $this->render('irrigation/index.html.twig', array(
            'irrigations' => $irrigations,
        ));
    }

    /**
     * Creates a new Irrigation entity.
     *
     * @Route("/new", name="irrigation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $irrigation = new Irrigation();
        $form = $this->createForm('AppBundle\Form\IrrigationType', $irrigation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($irrigation);
            $em->flush();

            return $this->redirectToRoute('irrigation_show', array('id' => $irrigation->getId()));
        }

        return $this->render('irrigation/new.html.twig', array(
            'irrigation' => $irrigation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Irrigation entity.
     *
     * @Route("/{id}", name="irrigation_show")
     * @Method("GET")
     */
    public function showAction(Irrigation $irrigation)
    {
        $deleteForm = $this->createDeleteForm($irrigation);

        return $this->render('irrigation/show.html.twig', array(
            'irrigation' => $irrigation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Irrigation entity.
     *
     * @Route("/{id}/edit", name="irrigation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Irrigation $irrigation)
    {
        $deleteForm = $this->createDeleteForm($irrigation);
        $editForm = $this->createForm('AppBundle\Form\IrrigationType', $irrigation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($irrigation);
            $em->flush();

            return $this->redirectToRoute('irrigation_edit', array('id' => $irrigation->getId()));
        }

        return $this->render('irrigation/edit.html.twig', array(
            'irrigation' => $irrigation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Irrigation entity.
     *
     * @Route("/{id}", name="irrigation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Irrigation $irrigation)
    {
        $form = $this->createDeleteForm($irrigation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($irrigation);
            $em->flush();
        }

        return $this->redirectToRoute('irrigation_index');
    }

    /**
     * Creates a form to delete a Irrigation entity.
     *
     * @param Irrigation $irrigation The Irrigation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Irrigation $irrigation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('irrigation_delete', array('id' => $irrigation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
