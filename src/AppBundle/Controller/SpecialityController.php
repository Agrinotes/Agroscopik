<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Speciality;
use AppBundle\Form\SpecialityType;

/**
 * Speciality controller.
 *
 * @Route("/speciality")
 */
class SpecialityController extends Controller
{
    /**
     * Lists all Speciality entities.
     *
     * @Route("/", name="speciality_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialities = $em->getRepository('AppBundle:Speciality')->findAll();

        return $this->render('speciality/index.html.twig', array(
            'specialities' => $specialities,
        ));
    }

    /**
     * Creates a new Speciality entity.
     *
     * @Route("/new", name="speciality_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $speciality = new Speciality();
        $form = $this->createForm('AppBundle\Form\SpecialityType', $speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($speciality);
            $em->flush();

            return $this->redirectToRoute('speciality_show', array('id' => $speciality->getId()));
        }

        return $this->render('speciality/new.html.twig', array(
            'speciality' => $speciality,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Speciality entity.
     *
     * @Route("/{id}", name="speciality_show")
     * @Method("GET")
     */
    public function showAction(Speciality $speciality)
    {
        $deleteForm = $this->createDeleteForm($speciality);

        return $this->render('speciality/show.html.twig', array(
            'speciality' => $speciality,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Speciality entity.
     *
     * @Route("/{id}/edit", name="speciality_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Speciality $speciality)
    {
        $deleteForm = $this->createDeleteForm($speciality);
        $editForm = $this->createForm('AppBundle\Form\SpecialityType', $speciality);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($speciality);
            $em->flush();

            return $this->redirectToRoute('speciality_edit', array('id' => $speciality->getId()));
        }

        return $this->render('speciality/edit.html.twig', array(
            'speciality' => $speciality,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Speciality entity.
     *
     * @Route("/{id}", name="speciality_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Speciality $speciality)
    {
        $form = $this->createDeleteForm($speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($speciality);
            $em->flush();
        }

        return $this->redirectToRoute('speciality_index');
    }

    /**
     * Creates a form to delete a Speciality entity.
     *
     * @param Speciality $speciality The Speciality entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Speciality $speciality)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('speciality_delete', array('id' => $speciality->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
